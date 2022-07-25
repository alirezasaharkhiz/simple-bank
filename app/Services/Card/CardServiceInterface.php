<?php

namespace App\Services\Card;

use App\Exceptions\CardNotFoundException;
use App\Exceptions\ErrorOnMysqlException;

interface CardServiceInterface
{
    /**
     * @param string $cardNumber
     * @return array
     * @throws CardNotFoundException
     * @throws ErrorOnMysqlException
     */
    public function validate(string $cardNumber): array;
}
