<?php namespace sbreiler\Localization;

use sbreiler\Localization\Type\Currency;
use sbreiler\Localization\Type\Number;
use sbreiler\Localization\Type\Date;

class Localization {
	protected static $local = null;
    protected static $locale_php = null;

    public static function getLocal() {
        if(null === static::$local) {
            static::$local = config('app.locale', 'en');
        }

        return static::$local;
    }

    public static function getLocalPHP() {
        if(null === static::$locale_php) {
            static::$locale_php = config('app.locale_php', 'en_US');
        }

        return static::$locale_php;
    }
	
	static function currency($value = 0.0, $currency_code = 'USD') {
		return Currency::create(static::getLocalPHP())
			->setValue($value);
	}
/*
	static function number($value = 0.0) {
		return new Number($value);
	}
	*/
}