<?php

namespace App\Services\Transaction;

use App\Constants\Constants;
use App\Exceptions\InsufficientBalanceException;
use App\Repositories\Account\Contracts\AccountRepositoryInterface;
use App\Repositories\Fee\Contracts\FeeRepositoryInterface;
use App\Repositories\Transaction\Contracts\TransactionRepositoryInterface;
use Illuminate\Support\Str;

class TransactionService implements TransactionServiceInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private TransactionRepositoryInterface $transactionRepository,
        private FeeRepositoryInterface $feeRepository
    ) {
    }

    public function validateSender(array $account, array $request): void
    {
        if ($account["balance"] - Constants::FEE < $request['amount']) {
            throw new InsufficientBalanceException();
        }
    }

    public function transact(array $fromAccount, array $toAccount, array $fromCard, array $toCard, float $amount): array
    {
        //TODO: add db transaction
        //TODO: flow needs to be async using event, job and listener (queueable)
        $fromAccountBalance = $fromAccount['balance'] - $amount - Constants::FEE;
        $this->accountRepository->updateWhere(['balance' => $fromAccountBalance], ['id' => $fromAccount['id']]);

        $toAccountBalance = $toAccount['balance'] + $amount;
        $this->accountRepository->updateWhere(['balance' => $toAccountBalance], ['id' => $toAccount['id']]);

        $transaction = $this->transactionRepository->insert([
            'from_card_id' => $fromCard['id'],
            'to_card_id' => $toCard['id'],
            'amount' => $amount,
            'follow_up_id' => Str::random(Constants::FOLLOW_UP_ID_LENGTH),
        ]);

        $fee = $this->feeRepository->insert([
            'transaction_id' => $transaction['id'],
            'amount' => Constants::FEE,
        ]);

        return $transaction;
    }
}
