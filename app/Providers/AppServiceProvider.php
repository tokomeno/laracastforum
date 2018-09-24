<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

// \Debugbar::disable();
        \View::composer(['threads.create', 'layouts.app'], function($view){
            $channels = \Cache::rememberForever('channels', function(){
                return \App\Channel::all();
            });
            $view->with('channels', $channels);
        });

        // \View::composer('*', function($view){
        //     $view->with('channels', \App\Channel::all());
        // });
        // \View::share('channels',  \App\Channel::all());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
