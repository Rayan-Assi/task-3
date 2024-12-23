<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
/* use Illuminate\Support\ServiceProvider; */

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $policies = [
        User::class => UserPolicy::class
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    

    public function boot()
    {
        $this->registerPolicies();
    
        Gate::define('manageUser', function ($user) {
            return $user->is_admin;
        });
    }
    
}
