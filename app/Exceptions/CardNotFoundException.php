<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class CardNotFoundException extends Exception
{
    public function __construct(string $message = "Card not found", int $code = Response::HTTP_NOT_FOUND, ?\Throwable $previous = null)
    {
        parent::__construct(__($message), $code, $previous);
    }
}
