<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class UnauthenticatedException extends ApiException
{
    protected int $statusCode = Response::HTTP_UNAUTHORIZED;

    public function __construct(string $message = 'Usuario no autenticado')
    {
        parent::__construct($message);
    }
}
