<?php

namespace App\Repositories\Card\Contracts;

use App\Exceptions\ErrorOnMysqlException;

interface CardRepositoryInterface
{
    /**
     * @param array $where
     * @return array|null
     * @throws ErrorOnMysqlException
     */
    public function firstWhere(array $where): ?array;
}
