<?php

namespace App\Providers;

use App\Events\ExampleEvent;
use App\Listeners\ExampleListener;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('visitAdminPage', function($user) {
            return $user->is_admin === 1;
        });

        Paginator::useBootstrapFive();

        Event::listen(
            ExampleEvent::class,
            ExampleListener::class,
        );
    }
}
