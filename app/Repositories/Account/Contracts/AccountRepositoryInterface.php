<?php

namespace App\Repositories\Account\Contracts;

use App\Exceptions\ErrorOnMysqlException;

interface AccountRepositoryInterface
{
    /**
     * @param array $where
     * @return array|null
     * @throws ErrorOnMysqlException
     */
    public function firstWhere(array $where): ?array;

    /**
     * @param array $data
     * @param array $where
     * @return bool
     * @throws ErrorOnMysqlException
     */
    public function updateWhere(array $data, array $where): bool;
}
