<?php

namespace BukanKalengKaleng\LaravelEntity;

use BukanKalengKaleng\LaravelEntity\Console\Commands\EntityMake;
use Illuminate\Support\ServiceProvider;

class LaravelEntityServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([EntityMake::class]);
        }

        $this->publishes([
            __DIR__.'/../config/entity.php' => config_path('entity.php'),
        ], 'laravel-entity');

        $this->mergeConfigFrom(__DIR__.'/../config/entity.php', 'entity');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
