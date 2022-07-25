<?php

namespace App\Repositories\Fee;

use App\Exceptions\ErrorOnMysqlException;
use App\Models\Fee;
use App\Repositories\Fee\Contracts\FeeRepositoryInterface;

class FeeEloquentRepository implements FeeRepositoryInterface
{
    public function insert($data): array
    {
        try {
            return Fee::create($data)->toArray();
        } catch (\Exception $exception) {
            throw new ErrorOnMysqlException();
        }
    }
}
