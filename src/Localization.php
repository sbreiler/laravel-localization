<?php namespace sbreiler\Localization;

use \DateTime;
use \NumberFormatter;
use \Locale;

use sbreiler\Localization\Helpers\Config;
use sbreiler\Localization\Types\Currency;
use sbreiler\Localization\Types\Number;
use sbreiler\Localization\Types\Date;

class Localization {
    protected static $defaultLocal = null;
    protected static $defaultTimezone = null;

    protected const LARAVEL_CONFIGNAME_LOCAL = 'local';
    protected const LARAVEL_CONFIGNAME_TIMEZONE = 'timezone';

    protected static function autoDetectLocal() {
        // by laravel config
        $config = Config::get(self::LARAVEL_CONFIGNAME_LOCAL, null, false);

        if( null !== $config ) {
            return $config;
        }

        // by browser language
        if(
            isset($_SERVER) &&
            is_array($_SERVER) &&
            array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER)
        ) {
            return Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        }

        // by INTL Extension config
        return Locale::getDefault();
    }

    protected static function autoDetectTimezone() {
        // by laravel config
        $config = Config::get(self::LARAVEL_CONFIGNAME_TIMEZONE, null, false);

        if( null !== $config ) {
            return $config;
        }

        // by "PHP"
        return date_default_timezone_get();
    }

    /**
     * @param string $local
     */
    public static function setDefaultLocal($local) {
        static::$defaultLocal = $local;
    }

    /**
     * @param string $timezone
     */
    public static function setDefaultTimezone($timezone) {
        static::$defaultTimezone = $timezone;
    }

    /**
     * @return string
     */
    public static function getDefaultLocal() {
        if( null === static::$defaultLocal ) {
            static::$defaultLocal = static::autoDetectLocal();
        }

        return static::$defaultLocal;
    }

    /**
     * @return string
     */
    public static function getDefaultTimezone() {
        if( null === static::$defaultTimezone ) {
            static::$defaultTimezone = static::autoDetectTimezone();
        }

        return static::$defaultTimezone;
    }

    /**
     * @param float $value
     * @param string $currency_code
     * @return Currency
     */
	static function currency($value = 0.0, $currency_code = Currency::DEFAULT_CURRENCY_CODE) {
		return Currency::create(
		    static::getDefaultLocal(),
            $currency_code
        )
			->setValue($value);
	}

    /**
     * @param float $value
     * @param int $style
     * @param null $pattern
     * @return Number
     */
	static function number($value = 0.0, $style = Number::DEFAULT_STYLE, $pattern = null) {
        return Number::create(static::getDefaultLocal(), $style, $pattern)
            ->setValue($value);
    }

    /**
     * @param float $value
     * @param null $pattern
     * @return Number
     */
    static function percentage($value = 0.0, $pattern = null) {
        return static::number($value, NumberFormatter::PERCENT, $pattern);
    }

    /**
     * @param int $value
     * @param null $pattern
     * @return Number
     */
    static function int($value = 0, $pattern = null) {
        return static::number($value, NumberFormatter::TYPE_INT32, $pattern);
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