<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsWaiter
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'waiter') {
            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthorized. waiter access only.'
        ], 403);
    }
}
