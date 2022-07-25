<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InsufficientBalanceException extends Exception
{
    public function __construct(string $message = "Insufficient Balance", int $code = Response::HTTP_UNPROCESSABLE_ENTITY, ?\Throwable $previous = null)
    {
        parent::__construct(__($message), $code, $previous);
    }
}
