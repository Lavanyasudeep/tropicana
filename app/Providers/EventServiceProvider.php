<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\LoginObserver;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LoginObserver::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
