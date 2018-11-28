<?php

namespace App\Http\Middleware;

use Closure;
use Debugbar;
use Auth;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Applicaion;
use Gettext\Translations;
use LaravelGettext;
class AdminMiddleware
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

        // if(Auth::check() && Auth::user()->is_admin != 1 ){
//            dd(1);
//            Auth::logout();
				if(Auth::check() && Auth::user()->is_admin == 1 ) {
					return $next($request);
					// return redirect('/' . LaravelGettext::getLocaleLanguage() . '/login');
				}else if (Auth::check() && Auth::user()->is_admin == null){
					return redirect('/' . LaravelGettext::getLocaleLanguage() . '/contact');

				}
            // return redirect('lv/no-admin')->with('warning', true)->with('form_message', _('You do not have admin rights to do any action here'));
//            return redirect()->route('login')->with('warning', true)->with('form_message', _('There is no such user in system'));

        }


}
