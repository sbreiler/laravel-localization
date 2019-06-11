<?php namespace sbreiler\Localization;

use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider {
	
	/**
     * Register the service provider.
     */
    public function register() {
        $this->app->alias(Localization::class, 'sbreiler-laravel-localization');
    }
}