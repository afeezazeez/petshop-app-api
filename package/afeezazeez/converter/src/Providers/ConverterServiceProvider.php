<?php

namespace Afeezazeez\Converter\Providers;

use Afeezazeez\Converter\Service\ConvertService;
use Illuminate\Support\ServiceProvider;

class ConverterServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'./../../config/convert.php', 'convert');

        $this->app->singleton('convert', function($app) {
            return new ConvertService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . './../../routes/api.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/convert.php' => config_path('convert.php'),
            ], 'config');
        }
    }

}
