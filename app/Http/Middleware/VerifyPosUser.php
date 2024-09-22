<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyPosUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role->name == 'pos' || auth()->user()->role->name == 'admin') {
            return $next($request);
        }
        return redirect()->route('homepage')->with([
            'message'    => "You do not have authorization to access that page.",
            'alert-type' => 'error',
        ]);
    }
}
