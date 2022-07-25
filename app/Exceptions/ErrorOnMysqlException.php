<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ErrorOnMysqlException extends Exception
{
    public function __construct(string $message = "Error on mysql", int $code = Response::HTTP_SERVICE_UNAVAILABLE, ?\Throwable $previous = null)
    {
        parent::__construct(__($message), $code, $previous);
    }
}
