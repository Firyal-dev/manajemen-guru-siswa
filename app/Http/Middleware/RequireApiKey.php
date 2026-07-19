<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-API-KEY');
        $validToken = config('app.api_access_token');

        if (!$token || !$validToken || !hash_equals($validToken, $token)) {
            return response()->json(['error' => 'Unauthorized. Invalid API Key.'], 401);
        }

        return $next($request);
    }
}
