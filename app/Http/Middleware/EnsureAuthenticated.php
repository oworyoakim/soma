<?php

namespace App\Http\Middleware;
use Closure;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($user = Sentinel::check()){
            return $next($request);
        }
        if($request->ajax()){
            return response()->json('Session Expired!',Response::HTTP_UNAUTHORIZED);
        }
        // Store this uri to return to after login
        $request->session()->put('url.intended',$request->url());
        return redirect()->route('login');
    }
}
