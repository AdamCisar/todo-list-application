<?php

use App\Http\Middlewares\EnsureJsonRequestMiddleware;
use App\Http\Responses\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
         $middleware->append(EnsureJsonRequestMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(fn(AuthenticationException $e, Request $request): JsonResponse => 
            ApiResponse::error(
                'Unauthenticated.', 
                null, 
                Response::HTTP_UNAUTHORIZED
            )
        );

        $exceptions->render(fn(ValidationException $e, $request): JsonResponse => 
               ApiResponse::error(
                'Validation failed.', 
                $e->errors(), 
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );

    })->create();
