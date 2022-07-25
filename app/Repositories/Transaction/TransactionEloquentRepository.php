<?php

namespace App\Repositories\Transaction;


use App\Exceptions\ErrorOnMysqlException;
use App\Models\Transaction;
use App\Repositories\Transaction\Contracts\TransactionRepositoryInterface;

class TransactionEloquentRepository implements TransactionRepositoryInterface
{
    public function insert(array $data): array
    {
        try {
            return Transaction::create($data)->toArray();
        } catch (\Exception $exception) {
            throw new ErrorOnMysqlException();
        }
    }
}
