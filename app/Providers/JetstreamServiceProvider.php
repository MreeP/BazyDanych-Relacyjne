<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

/**
 * Class JetstreamServiceProvider
 *
 * Service provider for Jetstream package.
 */
class JetstreamServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        Jetstream::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Silence is golden.
    }
}
