<?php

namespace BukanKalengKaleng\LaravelEntity;

use Illuminate\Support\ServiceProvider;
use BukanKalengKaleng\LaravelEntity\Console\Commands\EntityMake;
use BukanKalengKaleng\LaravelEntity\Console\Commands\EntityDestroy;

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
            __DIR__.'/path/to/config/entity.php' => config_path('entity.php'),
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
