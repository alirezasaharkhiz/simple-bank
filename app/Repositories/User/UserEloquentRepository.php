<?php

namespace App\Repositories\User;

use App\Exceptions\ErrorOnMysqlException;
use App\Models\User;
use App\Repositories\User\Contracts\UserRepositoryInterface;

class UserEloquentRepository implements UserRepositoryInterface
{
    public function insert(array $data): array
    {
        try {
            return User::create($data)->toArray();
        } catch (\Exception $exception) {
               throw new ErrorOnMysqlException();
        }
    }
}
