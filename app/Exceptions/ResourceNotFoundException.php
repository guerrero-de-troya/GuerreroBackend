<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ResourceNotFoundException extends ApiException
{
    protected int $statusCode = Response::HTTP_NOT_FOUND;

    public function __construct(string $resource, string $identifier = '')
    {
        $message = $identifier !== ''
            ? "{$resource} '{$identifier}' no encontrado"
            : "{$resource} no encontrado";

        parent::__construct($message);
    }

    /**
     * Factory method para recursos específicos
     */
    public static function forResource(string $resource, string $identifier = ''): self
    {
        return new self($resource, $identifier);
    }
}
