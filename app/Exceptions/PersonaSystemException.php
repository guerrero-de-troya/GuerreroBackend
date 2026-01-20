<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class PersonaSystemException extends ApiException
{
    protected int $statusCode = Response::HTTP_FORBIDDEN;

    public function __construct(string $message = 'No se puede realizar esta acción sobre una persona del sistema.')
    {
        parent::__construct($message);
    }
}
