<?php namespace sbreiler\Localization;

use \DateTime;
use \NumberFormatter;

use sbreiler\Localization\Type\Currency;
use sbreiler\Localization\Type\Number;
use sbreiler\Localization\Type\Date;

class Localization {
    public static function getDefaultLocal() {
        return config('localization.local');
    }

    public static function getDefaultTimezone() {
        return config('localization.timezone');
    }

	static function currency($value = 0.0, $currency_code = 'USD') {
		return Currency::create(static::getDefaultLocal())
			->setValue($value);
	}

	static function number($value = 0.0, $style = NumberFormatter::DECIMAL, $pattern = null) {
        return Number::create(static::getDefaultLocal(), $style, $pattern)
            ->setValue($value);
    }

    /**
     * @param null|string|DateTime $value
     * @return Date
     */
    static function date($value = null) {
        return Date::create(static::getDefaultLocal())
            ->setValue($value);
    }
}