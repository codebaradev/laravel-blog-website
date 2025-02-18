<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    protected $singletons = [
        \App\Services\UserService::class => \App\Services\UserService::class,
        \App\Services\BlogService::class => \App\Services\BlogService::class,
    ];
    
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
