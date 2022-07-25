<?php

namespace App\Services\Account;

use App\Exceptions\AccountNotFoundException;
use App\Exceptions\ErrorOnMysqlException;

interface AccountServiceInterface
{
    /**
     * @param int $id
     * @return array
     * @throws AccountNotFoundException
     * @throws ErrorOnMysqlException
     */
    public function findById(int $id): array;
}
