<?php

namespace App\Http\Middleware;

use Closure;
use Cache;

use Illuminate\Routing\Redirector;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;


class Language
{

    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        dd($next);
//        dd($request->path());
//        var_dump($request->path());

        if (strpos($request->path(), '_debugbar') !== false) {
            return $next($request);
        }
        // if (strpos($request->path(), 'imagecache') !== false) {
        //     return $next($request);
        // }

        if (strpos($request->path(), 'login') !== false) { 
            return $next($request);
        }

        if (strpos($request->path(), 'logout') !== false) {
            return $next($request);
        }

        if (strpos($request->path(), 'register') !== false) {
            return $next($request);
        }

        if (strpos($request->path(), 'reset') !== false) {
            return $next($request);
        }

        if (strpos($request->path(), 'password') !== false) {
            return $next($request);
        }

        if (strpos($request->path(), 'password/reset') !== false) {
            return $next($request);
        }


        if (strpos($request->path(), 'password/email') !== false) {
            return $next($request);
        }



        $locale = $request->segment(1);

        $languages = Cache::rememberForever('languages', function() {
            return \App\Language::get();
        });

        // dd($languages->pluck('abbr', 'abbr')->toArray());

        if ( ! array_key_exists($locale, $languages->pluck('abbr', 'abbr')->toArray() ) ) {


            $segments = $request->segments();

            $segments[0] = config('constants.DEFAULT_LOCALE');



            return redirect(implode('/', $segments));
        }


        $language = $languages->filter(function($lang) use($locale){
            return $lang->abbr == $locale;
        })->first();

        view()->share('selectedLanguage', $language);

        \App::setLocale($locale);
        $locales = config('app.locales');
        $localeCode = array_get($locales, $locale, 'en_GB');

        app('laravel-gettext')->setLocale($localeCode);
//        var_dump($localeCode);
//        dd( \App::getLocale() );
        return $next($request);
    }
}
