<?php

namespace App\Repositories\Transaction\Contracts;

use App\Exceptions\ErrorOnMysqlException;

interface TransactionRepositoryInterface
{
    /**
     * @param array $data
     * @return array
     * @throws ErrorOnMysqlException
     */
    public function insert(array $data): array;
}
