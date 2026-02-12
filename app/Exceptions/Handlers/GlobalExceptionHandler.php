<?php declare(strict_types=1);

namespace App\Exceptions\Handlers;

use App\Http\Responses\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Exception;

/*
 * Global exception handler to catch and handle all global exceptions thrown in the application. * This allows us to return consistent JSON responses for all errors, regardless of where they occur in the application. * We can also customize the error messages and status codes based on the type of exception thrown.
 */
class GlobalExceptionHandler
{
    private static function render(Exception $e, $request): JsonResponse|null
    {
        $exceptionData = match ($e::class) {
            AuthenticationException::class => [
                'Unauthenticated.',
                null,
                Response::HTTP_UNAUTHORIZED,
            ],
            ValidationException::class => [
                'Validation failed.',
                $e->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            MethodNotAllowedHttpException::class => [
                'Method or parameter not allowed.',
                null,
                Response::HTTP_METHOD_NOT_ALLOWED,
            ],
            default => config('app.debug')
                ? null
                : [
                    'An unexpected error occurred.',
                    null,
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                ],
        };

        if (!$exceptionData) {
            return null;
        }

        return ApiResponse::error(...$exceptionData);
    }

    public static function register(Exceptions $exceptions)
    {
        $exceptions->render(fn(Exception $e, $request): JsonResponse|null => static::render($e, $request));
    }
}
