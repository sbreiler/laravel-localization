<?php namespace sbreiler\Localization;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\Analytics\Analytics
 */
class LocalizationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sbreiler-laravel-localization';
    }
}