<?php

namespace App\Http\Middleware;

use Closure;
use Debugbar;
use Auth;

class BeforeMiddleware
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

        if( env('APP_DEBUG') == 'true'){
            if(!Auth::check() or (Auth::user()->is_developer !=1)){
//                Debugbar::disable();
                
//                env('APP_DEBUG') = false;
//                \Config::set('app.debug', false);
            }
        }
//        \Config::set('app.debug', false);
//        dd(Config::get('app.debug'));
        return $next($request);
    }
}
