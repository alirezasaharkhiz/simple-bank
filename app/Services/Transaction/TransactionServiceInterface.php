<?php

namespace App\Services\Transaction;

use App\Exceptions\ErrorOnMysqlException;
use App\Exceptions\InsufficientBalanceException;

interface TransactionServiceInterface
{
    /**
     * @param array $account
     * @param array $request
     * @return void
     * @throws InsufficientBalanceException
     * @throws ErrorOnMysqlException
     */
    public function validateSender(array $account, array $request): void;

    /**
     * @param array $fromAccount
     * @param array $toAccount
     * @param array $fromCard
     * @param array $toCard
     * @param float $amount
     * @return array
     * @throws ErrorOnMysqlException
     */
    public function transact(array $fromAccount, array $toAccount, array $fromCard, array $toCard, float $amount): array;
}
