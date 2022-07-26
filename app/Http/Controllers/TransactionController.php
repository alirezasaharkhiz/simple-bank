<?php

namespace App\Http\Controllers;

use App\Exceptions\AccountNotFoundException;
use App\Exceptions\CardNotFoundException;
use App\Exceptions\ErrorOnMysqlException;
use App\Exceptions\InsufficientBalanceException;
use App\Http\Requests\MakeTransactionRequest;
use App\Services\Account\AccountServiceInterface;
use App\Services\Card\CardServiceInterface;
use App\Services\Transaction\TransactionServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionServiceInterface $transactionService,
        private AccountServiceInterface $accountService,
        private CardServiceInterface $cardService
    ) {
    }

    /**
     * @param MakeTransactionRequest $request
     * @return JsonResponse
     */
    public function makeTransaction(MakeTransactionRequest $request): JsonResponse
    {
        try {
            //TODO: develop request service
            $request = $request->validated();

            //TODO: layers should use an entity to talk to each
            $fromCard = $this->cardService->validate($request['from']);
            $toCard = $this->cardService->validate($request['to']);

            $fromAccount = $this->accountService->findById($fromCard['account_id']);
            $toAccount = $this->accountService->findById($toCard['account_id']);

            $this->transactionService->validateSender($fromAccount, $request);
            $result = $this->transactionService->transact($fromAccount, $toAccount, $fromCard, $toCard, $request['amount']);

            //TODO: develop response service
            return response()->json([
                'message' => 'Transaction submitted',
                'error' => null,
                'data' => [
                    'from_card' => $fromCard['public_number'],
                    'to_card' => $toCard['public_number'],
                    'amount' => $result['amount'],
                    'follow_up_id' => $result['follow_up_id'],
                    //TODO: user full_name must be added to response
                ]
            ], Response::HTTP_CREATED);
        } catch (CardNotFoundException|AccountNotFoundException|InsufficientBalanceException $exception) {
            return response()->json([
                'message' => 'Failed to transact',
                'error' => $exception->getMessage(),
                'data' => []
            ], $exception->getCode());
        } catch (ErrorOnMysqlException $exception) {
            //TODO: write exception in a log driver
            return response()->json([
                'message' => 'Failed to transact',
                'error' => "Service unavailable try again later",
                'data' => []
            ], $exception->getCode());
        } catch (\Exception $exception) {
            //TODO: write exception in a log driver
            return response()->json([
                'message' => 'Failed to transact',
                'error' => 'Failed to transact',
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
