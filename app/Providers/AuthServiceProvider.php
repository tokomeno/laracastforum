<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
         'App\Thread' => 'App\Policies\ThreadPolicy',
          // Thread::class => ThreadPolicy::class,
          'App\Reply' => 'App\Policies\ReplyPolicy',
          'App\User' => 'App\Policies\UserPolicy',
        // Reply::class => ReplyPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::before(function($user){
        //     if( $user->name === 'Toko' ) return true;
        // });

        Gate::before(function ($user) {
            if ($user->name === 'tes') {
                return true;
            }
        });
    }
}
