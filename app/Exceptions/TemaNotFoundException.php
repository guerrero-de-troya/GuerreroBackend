<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Http\Response;

class TemaNotFoundException extends ApiException
{
    protected int $statusCode = Response::HTTP_NOT_FOUND;

    public function __construct(string $temaName = '')
    {
        $message = $temaName !== ''
            ? "Tema '{$temaName}' no encontrado"
            : 'Tema no encontrado';

        parent::__construct($message);
    }
}
