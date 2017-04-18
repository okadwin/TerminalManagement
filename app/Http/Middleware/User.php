<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class User
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
        if (Sentinel::check()){
            return $next($request);
        }else{
            return redirect(action('UserController@LoginView'));
        }

    }
}
