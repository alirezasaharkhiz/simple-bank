<?php

namespace App\Repositories\Card;

use App\Exceptions\ErrorOnMysqlException;
use App\Models\Card;
use App\Repositories\Card\Contracts\CardRepositoryInterface;

class CardEloquentRepository implements CardRepositoryInterface
{
    public function firstWhere(array $where): ?array
    {
        try {
            return Card::where($where)->first()?->toArray();
        } catch (\Exception $exception) {
            throw new ErrorOnMysqlException();
        }
    }
}
