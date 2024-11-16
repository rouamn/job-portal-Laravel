<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtAuth
{
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Try to get the user from the token
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            // If there is an issue with the token, respond with an error
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Proceed with the request
        return $next($request);
    }
}
