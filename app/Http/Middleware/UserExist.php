<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Applicaion;
use Auth;


class UserExist  {
	/**
	 * Проверяем авторизован ли пользователь
	 * если нет, то перенаправляем его на форму авторизации
	 */
	 public function handle($request, Closure $next)
 	{

 			if(Auth::user()->is_admin == null  ){
            dd(1);
 //            Auth::logout();
 					return redirect('lv/no-admin')->with('warning', true)->with('form_message', _('You do not have admin rights to do any action here'));
 //            return redirect()->route('login')->with('warning', true)->with('form_message', _('There is no such user in system'));

 			}
 			return $next($request);
 	}
}
