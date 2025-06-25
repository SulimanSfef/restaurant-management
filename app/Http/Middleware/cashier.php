<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCashier
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'cashier') {
            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthorized. cashier access only.'
        ], 403);
    }
}

