<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
<<<<<<< HEAD
        
=======
        Gate::Define('acces-admin',function($user){

        return $user->is_admin;
        });
>>>>>>> 3eb72ef463e64be5c52cb1e34670dd12a44634f5
    }
}
