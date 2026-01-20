<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class ApiException extends Exception
{
    protected int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function render(): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'message' => $this->getMessage(),
            ],
            $this->getStatusCode()
        );
    }
}
