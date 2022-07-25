<?php

namespace App\Repositories\Fee\Contracts;

use App\Exceptions\ErrorOnMysqlException;

interface FeeRepositoryInterface
{
    /**
     * @param $data
     * @return array
     * @throws ErrorOnMysqlException
     */
    public function insert($data): array;
}
