<?php

namespace App\Features\Todo\Exceptions;

use App\Http\Responses\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class TodoUpdateException extends Exception
{
    protected $message = 'Todo update failed.';

    /**
     * Render the exception into an HTTP response.
     */
    public function render($request): JsonResponse
    {
        return ApiResponse::error($this->message, null, Response::HTTP_BAD_REQUEST);
    }
}
