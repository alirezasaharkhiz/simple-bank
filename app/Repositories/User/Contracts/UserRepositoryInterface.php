<?php

namespace App\Repositories\User\Contracts;

use App\Exceptions\ErrorOnMysqlException;

interface UserRepositoryInterface
{
    /**
     * @param array $data
     * @return array
     * @throws ErrorOnMysqlException
     */
    public function insert(array $data): array;
}
