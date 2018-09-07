<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
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
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        $gate->define('isSuperAdmin', function($user){
            return $user->level == 1;
        });

        $gate->define('isCompany', function($user){
            return $user->level == 2;
        });
            
        $gate->define('isAdmin', function($user){
            return $user->level == 3;
        });

        $gate->define('isAuthor', function($user){
            return $user->level == 4;
        });

        $gate->define('isUser', function($user){
            return $user->level == 5;
        });

        $gate->define('isCustomer', function($user){
            return $user->level == 6;
        });
    }
}
