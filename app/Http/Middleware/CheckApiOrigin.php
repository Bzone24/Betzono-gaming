<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiOrigin
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
        $allowedOrigins = [
            env('API_ALLOWED_ORIGIN', ''),
            'https://stakeye.com',
        ];
        $requestOrigin = $request->header('Origin') 
        ?? $request->header('Referer') 
        ?? $request->header('Host');

        if(){
            
        }

        $formattedHost = $request->getScheme() . '://' . $requestOrigin;

        if (in_array('*', $allowedOrigins)) {
            return $next($request);
        }
        // $allowedOrigin = env('API_ALLOWED_ORIGIN', '');

        // If allowed origin is *, allow all origins
        if ($allowedOrigin === '*') {
            return $next($request);
        }

        // If specific origin is set, check if request origin matches
        $requestOrigin = $request->header('Origin');

        if ($requestOrigin && in_array($requestOrigin, explode(',', $allowedOrigin))) {
            return $next($request);
        }

        // If origin is not allowed, return a forbidden response
        return response()->json(['error' => 'Unauthorized origin'], 403);
    }
}
