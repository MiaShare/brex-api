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
        $source = realpath(__DIR__ . '/config/brex.php');

        $this->publishes([$source => config_path('brex.php')]);

        $this->mergeConfigFrom($source, 'brex');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->bind(BrexApi::class, function () {
            return new BrexApi(config('brex.api_token'));
        });

        $this->app->alias(BrexApi::class, 'brex-api');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [BrexApi::class];
    }
}