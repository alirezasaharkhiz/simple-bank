<?php

namespace App\Repositories\Account;

use App\Exceptions\ErrorOnMysqlException;
use App\Models\Account;
use App\Repositories\Account\Contracts\AccountRepositoryInterface;

class AccountEloquentRepository implements AccountRepositoryInterface
{
    public function firstWhere(array $where): ?array
    {
        try {
            return Account::where($where)->first()?->toArray();
        } catch (\Exception $exception) {
            throw new ErrorOnMysqlException();
        }
    }

    public function updateWhere(array $data, array $where): bool
    {
        try {
            return (bool)Account::where($where)->update($data);
        } catch (\Exception $exception) {
            throw new ErrorOnMysqlException();
        }
    }
}
