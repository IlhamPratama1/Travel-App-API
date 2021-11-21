<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;

class VerifyIsAdmin
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
        if (! $request->user() ||
             ($request->user() instanceof MustVerifyEmail &&
             ! $request->user()->hasVerifiedEmail()) ||
             $request->user()->role !== "admin") {
             return $request->expectsJson()
                     ? abort(403, 'Admin role required.')
                     : Redirect::route('verification.notice');
         }

         return $next($request);
    }
}
