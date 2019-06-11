<?php namespace sbreiler\Localization;

use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/localization.php' => config_path('localization.php'),
        ]);
    }

	/**
     * Register the service provider.
     */
    public function register() {
        $this->mergeConfigFrom(__DIR__.'/../config/localization.php', 'localization');

        $this->app->bind(Localization::class, function () {
            return new Localization(config('localization'));
        });

        $this->app->alias(Localization::class, 'sbreiler-laravel-localization');
    }
}