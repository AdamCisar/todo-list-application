<?php

declare(strict_types=1);

namespace App\Http\Middlewares;

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
            return response()->json([
                'success' => false,
                'message' => 'Invalid request format. JSON expected. Please set the "Accept" header to "application/json".',
                'data' => null,
            ], 403);
        }

        return $next($request);
    }
}
