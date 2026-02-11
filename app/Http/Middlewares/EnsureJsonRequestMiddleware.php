<?php

declare(strict_types=1);

namespace App\Http\Middlewares;

use App\Http\Responses\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureJsonRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->expectsJson()) {
            return ApiResponse::error(
                'Invalid request format. JSON expected. Please set the "Accept" header to "application/json".', 
                null, 
                Response::HTTP_FORBIDDEN
            );
        }

        return $next($request);
    }
}
