<?php

namespace App\Features\Todo\Exceptions;

use App\Http\Responses\ApiResponse;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TodoNotFoundException extends Exception
{
    protected $message = 'Todo not found.';

    /**
     * Render the exception into an HTTP response.
     */
    public function render($request): JsonResponse
    {
        return ApiResponse::error($this->message, null, Response::HTTP_NOT_FOUND);
    }
}
