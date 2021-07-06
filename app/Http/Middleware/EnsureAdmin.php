<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureAdmin
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
        if(Sentinel::check() && !Sentinel::inRole('student')){
            return $next($request);
        }
        if ($request->expectsJson())
        {
            return response()->json('Session Expired!',Response::HTTP_UNAUTHORIZED);
        }
        $user = Sentinel::getUser();
        Sentinel::logout($user, true);
        return response()->view("admin.login", ['error' => "Unauthorized Access!"]);
    }
}
