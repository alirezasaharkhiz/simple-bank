<?php

namespace Tests\Feature\Transactions;

use App\Externals\helpers\Helper;
use App\Http\Controllers\TransactionController;
use App\Repositories\Account\AccountEloquentRepository;
use App\Repositories\Card\CardEloquentRepository;
use App\Repositories\User\UserEloquentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MakeTransactionTest extends TestCase
{
    use RefreshDatabase;

    private function prepareData(): array
    {
        try {
            $user = (new UserEloquentRepository())->insert([
                'full_name' => Str::random(5),
                'mobile' => rand(2000000, 999999999),
            ]);

            $account = (new AccountEloquentRepository())->insert([
                'public_uuid' => Str::uuid()->toString(),
                'balance' => rand(2000000, 999999999),
                'user_id' => $user['id']
            ]);

            $card = (new CardEloquentRepository())->insert([
                'public_number' => Helper::generateCardNumber(),
                'account_id' => $account['id'],
            ]);

            return [
                'user' => $user,
                'account' => $account,
                'card' => $card
            ];
        } catch (\Exception $exception) {
            dd($exception->getMessage(), $exception->getLine());
        }
    }

    public function test_success_transaction()
    {
        $data1 = $this->prepareData();
        $data2 = $this->prepareData();
        $amount = 50000;

        $response = $this->post(action([TransactionController::class, 'makeTransaction']), [
            'from' => $data1['card']['public_number'],
            'to' => $data2['card']['public_number'],
            'amount' => $amount,
        ])->assertStatus(Response::HTTP_CREATED)->assertJsonStructure([
            'message',
            'error',
            'data' => [
                'from_card',
                'to_card',
                'amount',
                'follow_up_id'
            ]
        ])->assertJsonPath('message', __("Transaction submitted"))
            ->assertJsonPath('error', null);

        $this->assertIsArray($response['data']);
        $this->assertEquals($data1['card']['public_number'], $response['data']['from_card']);
        $this->assertEquals($data2['card']['public_number'], $response['data']['to_card']);
        $this->assertEquals($amount, $response['data']['amount']);
        $this->assertArrayHasKey('follow_up_id', $response['data']);
        $this->assertNotNull($response['data']['follow_up_id']);

        $this->assertDatabaseHas('transactions', [
            'from_card_id' => $data1['card']['id'],
            'to_card_id' => $data2['card']['id'],
            'follow_up_id' => $response['data']['follow_up_id']
        ]);

        $this->assertDatabaseCount('transactions', 1);
        $this->assertDatabaseCount('fees', 1);
    }

    public function test_fail_transaction_with_invalid_input_for_sender_card_number_rule()
    {
        $response = $this->post(action([TransactionController::class, 'makeTransaction']),
            [
                'from' => 123,
                'to' => Helper::generateCardNumber(),
                'amount' => 50000,
            ],
            [
                "Accept" => "application/json"
            ]
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJsonStructure([
            'message',
            'errors' => [
                'from' => []
            ],
        ]);

        $this->assertArrayHasKey('from', $response['errors']);
        $this->assertCount(1, $response['errors']['from']);
        $this->assertEquals(__("Invalid Card Number from"), $response['errors']['from'][0]);
    }

    public function test_fail_transaction_with_invalid_input_for_receiver_card_number_rule()
    {
        $response = $this->post(action([TransactionController::class, 'makeTransaction']),
            [
                'from' => Helper::generateCardNumber(),
                'to' => 123,
                'amount' => 50000,
            ],
            [
                "Accept" => "application/json"
            ]
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJsonStructure([
            'message',
            'errors' => [
                'to' => []
            ],
        ]);

        $this->assertArrayHasKey('to', $response['errors']);
        $this->assertCount(1, $response['errors']['to']);
        $this->assertEquals(__("Invalid Card Number to"), $response['errors']['to'][0]);
    }

    public function test_fail_transaction_when_sender_card_not_found()
    {
        $data = $this->prepareData();

        $response = $this->post(action([TransactionController::class, 'makeTransaction']),
            [
                'from' => Helper::generateCardNumber(),
                'to' => $data['card']['public_number'],
                'amount' => 50000,
            ],
            [
                "Accept" => "application/json"
            ]
        )->assertStatus(Response::HTTP_NOT_FOUND)->assertJsonStructure([
            'message',
            'error',
            'data' => []
        ])->assertJsonPath('message', __("Failed to transact"))
            ->assertJsonPath('error', __("Card not found"));

        $this->assertCount(0, $response['data']);
    }

    public function test_fail_transaction_when_receiver_card_not_found()
    {
        $data = $this->prepareData();

        $response = $this->post(action([TransactionController::class, 'makeTransaction']),
            [
                'from' => $data['card']['public_number'],
                'to' => Helper::generateCardNumber(),
                'amount' => 50000
            ],
            [
                "Accept" => "application/json"
            ]
        )->assertStatus(Response::HTTP_NOT_FOUND)->assertJsonStructure([
            'message',
            'error',
            'data' => []
        ])->assertJsonPath('message', __("Failed to transact"))
            ->assertJsonPath('error', __("Card not found"));

        $this->assertCount(0, $response['data']);
    }

    //TODO: Add tests for sender & receiver account not found exception also,
    // Add test for mysql repository database exception
    //TODO: Add tests for Insufficient Balance for sender
}
