<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class PersonaNotFoundException extends ApiException
{
    protected int $statusCode = Response::HTTP_NOT_FOUND;

    public function __construct(string $message = 'Persona no encontrada')
    {
        parent::__construct($message);
    }
}
