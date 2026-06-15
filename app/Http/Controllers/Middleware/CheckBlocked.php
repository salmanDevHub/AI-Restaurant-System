<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBlocked
{
   public function handle(Request $request, Closure $next)
{
    if (Auth::check() && Auth::user()->is_blocked) {

        Auth::logout();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your account has been blocked.'
            ], 403);
        }

        return redirect()->route('login')
            ->with('error', 'Your account has been blocked. Please contact support.');
    }

    return $next($request);
}
}