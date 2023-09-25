<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Session;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check())
        {
            if(Auth::user()->isAdmin)
            {
                return $next($request);
            }
            Session::flash('error','Access Denied');
            return back();
        }
        return url('/login');
    }
}
