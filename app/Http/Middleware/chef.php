<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsChef
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'chef') {
            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthorized. chef access only.'
        ], 403);
    }
}
