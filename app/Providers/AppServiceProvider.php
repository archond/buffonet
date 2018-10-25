<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $languages = Cache::rememberForever('languages', function() {
            return \App\Language::get();
        });
        view()->share('languages', $languages);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \App::bind('Illuminate\Routing\ResourceRegistrar', function ()
        {
            return \App::make('App\Providers\ResourceNoPrefixRegistrar'); 
        });

        if (!config('app.debug')) {
            $this->app->register(\Jenssegers\Rollbar\RollbarServiceProvider::class);
        }

    }
}
