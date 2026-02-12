<?php

namespace App\Features\Todo\Exceptions;

use App\Http\Responses\ApiResponse;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TodoDeleteException extends Exception
{
    protected $message = 'Failed to delete todo.';

    /**
     * Render the exception into an HTTP response.
     */
    public function render($request): JsonResponse
    {
        return ApiResponse::error($this->message, null, Response::HTTP_BAD_REQUEST);
    }
}
