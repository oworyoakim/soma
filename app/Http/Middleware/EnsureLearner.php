<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureLearner
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Sentinel::inAnyRole(['student']))
        {
            return $next($request);
        }
        $user = Sentinel::getUser();
        Sentinel::logout($user, true);
        return redirect()->route('login')->with('error', "Unauthorized Access!");
    }
}
