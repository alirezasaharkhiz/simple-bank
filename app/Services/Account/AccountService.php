<?php

namespace App\Services\Account;

use App\Exceptions\AccountNotFoundException;
use App\Exceptions\ErrorOnMysqlException;
use App\Repositories\Account\Contracts\AccountRepositoryInterface;

class AccountService implements AccountServiceInterface
{
    public function __construct(private AccountRepositoryInterface $accountRepository)
    {
    }

    public function findById(int $id): array
    {
        $account = $this->accountRepository->firstWhere(['id' => $id]);
        if(!$account) {
            throw new AccountNotFoundException();
        }

        return $account;
    }
}
