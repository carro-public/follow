<?php

namespace CarroPublic\Follow;

use Illuminate\Support\ServiceProvider;

class FollowServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/follow.php', 'follow');

        // Register the service the package provides.
        $this->app->singleton('follow', function ($app) {
            return new Follow;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['follow'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/follow.php' => config_path('follow.php'),
        ], 'follow.config');

        $this->publishes([
            __DIR__.'/../database/migrations/create_follows_table.php.stub' =>
                database_path('migrations/'.date('Y_m_d_His', time()).'_create_follows_table.php'),
        ], 'migrations');
    }
}
