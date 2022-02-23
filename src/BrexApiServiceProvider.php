<?php

namespace MiaShare\BrexApi;

use Illuminate\Support\ServiceProvider;
use MiaShare\BrexApi\BrexApi;

class BrexApiServiceProvider extends ServiceProvider {
	/**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-pokemontcg');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-pokemontcg');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/brex.php' => config_path('brex.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-pokemontcg'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-pokemontcg'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-pokemontcg'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/brex.php', 'brex');

        // Register the main class to use with the facade
        $this->app->singleton('brex-api', function () {
            return new BrexApi(config('brex.api_token'));
        });
    }
}