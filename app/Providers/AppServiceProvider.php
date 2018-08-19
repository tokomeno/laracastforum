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
        \View::composer(['threads.create', 'layouts.app'], function($view){
            $view->with('channels', \App\Channel::all());
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
