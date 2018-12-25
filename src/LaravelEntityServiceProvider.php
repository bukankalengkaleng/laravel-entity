<?php

namespace BukanKalengKaleng\LaravelEntity;

use Illuminate\Support\ServiceProvider;
use BukanKalengKaleng\LaravelEntity\Console\Commands\EntityMake;

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
            __DIR__.'/src/config/entity.php' => config_path('entity.php'),
        ]);
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
