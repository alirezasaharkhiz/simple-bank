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

    /**
     * @param array $data
     * @return array
     * @throws ErrorOnMysqlException
     */
    public function insert(array $data): array;
}
