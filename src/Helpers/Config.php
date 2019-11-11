<?php namespace sbreiler\Localization\Helpers;

use \Illuminate\Support\Arr;
use \Illuminate\Support\Str;
use sbreiler\Localization\Types\Currency;

class Config {
    protected const CONFIG_FALLBACK = [
        'currency' => [
            'model_cast' => ['currency','curr','c'],
            'default_currency_code' => Currency::DEFAULT_CURRENCY_CODE
        ],
        'date' => [
            'model_cast' => ['date','d']
        ],
        'number' => [
            'model_cast' => ['number','num','n']
        ]
    ];

    protected const CONFIG_PREFIX = 'localization.';

    /**
     * @param string $key
     * @return bool
     */
    protected static function hasConfigKeyPrefix(string $key): bool {
        return Str::startsWith(
            strtolower($key),
            strtolower(self::CONFIG_PREFIX)
        );
    }

    /**
     * @param string $key
     * @return string
     */
    protected static function removeConfigKeyPrefix(string $key): string {
        return (
            self::hasConfigKeyPrefix($key)
            ? substr($key, strlen(self::CONFIG_PREFIX))
            : $key
        );
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null, $use_fallback = true) {
        $withPrefix = (self::hasConfigKeyPrefix($key) ? $key : self::CONFIG_PREFIX . $key);

        // by laravel config
        if(
            function_exists('config') &&
            config()->has($withPrefix)
        ) {
            return config($withPrefix);
        }

        // by fallback
        if( $use_fallback ) {
            return Arr::get(self::CONFIG_FALLBACK, self::removeConfigKeyPrefix($key), $default);
        }

        return $default;
    }
}