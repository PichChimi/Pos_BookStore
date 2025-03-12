<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
      
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
         Gate::define('homeList', function ($user) {
            return $user->role && strtolower($user->role->name_en) === 'admin';
         });

         Gate::define('systemList', function ($user) {
            return $user->role && strtolower($user->role->name_en) === 'admin';
         });

         Gate::define('productList', function ($user) {
            return $user->role && strtolower($user->role->name_en) === 'admin';
         });

         Gate::define('inventoryList', function ($user) {
            return $user->role && strtolower($user->role->name_en) === 'admin';
         });

         Gate::define('reportSaleList', function ($user) {
            return $user->role && strtolower($user->role->name_en) === 'admin';
         });
      
    }
}
