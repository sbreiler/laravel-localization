<?php namespace sbreiler\Localization\Helpers;

use sbreiler\Localization\Localization;
use sbreiler\Localization\Types\Currency;
use sbreiler\Localization\Types\Date;
use sbreiler\Localization\Types\Number;

class Type {
    const DATE_FORMATS = [
        'FULL' => \IntlDateFormatter::FULL,
        'LONG' => \IntlDateFormatter::LONG,
        'MEDIUM' => \IntlDateFormatter::MEDIUM,
        'SHORT' => \IntlDateFormatter::SHORT
    ];

    const NUMBER_FORMATS = [
        'DECIMAL' => \NumberFormatter::DECIMAL,
        'CURRENCY' => \NumberFormatter::CURRENCY,
        'PERCENT' => \NumberFormatter::PERCENT,
        'SCIENTIFIC' => \NumberFormatter::SCIENTIFIC,
        'SPELLOUT' => \NumberFormatter::SPELLOUT,
        'ORDINAL' => \NumberFormatter::ORDINAL,
        'DURATION' => \NumberFormatter::DURATION
    ];

    public static function getModelCastsFor($type): array {
        return Config::get(trim(trim($type,'.')) . '.model_cast', []);
    }

    /**
     * @param $value
     * @param string|array $settings
     * @param mixed $default
     * @return Currency|Date|Number|null
     */
    public static function castModelValueTo($value, $settings, $default = null) {
        if( true === is_string($settings) ) {
            $settings = explode('|', $settings);
            $settings['type'] = $settings[0];
        }

        if( isset($settings['type']) ) {
            switch(self::getTypeOfString($settings['type'])) {
                case Currency::class:
                    $currency_code = null;

                    if( array_key_exists('currency', $settings) ) {
                        $currency_code = $settings['currency'];
                    }
                    elseif( isset($settings[1]) ) {
                        $currency_code = $settings[1];
                    }

                    return Localization::currency($value, $currency_code);

                case Date::class:
                    $dateType = null;
                    $timeType = null;

                    if( array_key_exists('dateType', $settings) ) {
                        $dateType = self::parseStringToDateFormat($settings['dateType'], null);
                    }
                    elseif( isset($settings[1]) ) {
                        $dateType = self::parseStringToDateFormat($settings[1], null);
                    }

                    if( array_key_exists('timeType', $settings) ) {
                        $dateType = self::parseStringToDateFormat($settings['timeType'], null);
                    }
                    elseif( isset($settings[2]) ) {
                        $dateType = self::parseStringToDateFormat($settings[2], null);
                    }

                    return Localization::date($value, $dateType ?? Date::DEFAULT_FORMAT, $timeType ?? Date::DEFAULT_FORMAT);

                case Number::class:
                    $style = null;

                    if( array_key_exists('style', $settings) ) {
                        $style = Type::parseStringToNumberFormat($settings['style'], null);
                    }
                    elseif( isset($settings[1]) ) {
                        $style = Type::parseStringToNumberFormat($settings[1], null);
                    }

                    return Localization::number($value, $style ?? Number::DEFAULT_STYLE);
            }
        }

        return $default;
    }

    /**
     * @param string $input
     * @param mixed $default
     * @return int
     */
    public static function parseStringToDateFormat(string $input, $default = Date::DEFAULT_FORMAT) {
        if( is_string($input) ) {
            $tmp_input = strtoupper(trim($input));

            if( array_key_exists($tmp_input, Date::FORMATS) ) {
                return Date::FORMATS[$tmp_input];
            }
        }

        if( is_numeric($input) && in_array((int)$input, Date::FORMATS) ) {
            return (int)$input;
        }

        return $default;
    }

    /**
     * @param string $input
     * @param mixed $default
     * @return int|mixed
     */
    public static function parseStringToNumberFormat(string $input, $default = Number::DEFAULT_STYLE) {
        if( is_string($input) ) {
            $tmp_input = strtoupper(trim($input));

            if( array_key_exists($tmp_input, Number::STYLE) ) {
                return Number::STYLE[$tmp_input];
            }
        }

        if( is_numeric($input) && in_array((int)$input, Number::STYLE) ) {
            return (int)$input;
        }

        return $default;
    }

    /**
     * @param object|string $object
     * @param bool $allowString
     * @param bool $allowLooseString
     * @return string|null
     */
    public static function getTypeOf($object, $allowString = true, $allowLooseString = true) {
        if( is_object($object) ) {
            if( $object instanceof Currency ) {
                return Currency::class;
            }
            if( $object instanceof Date ) {
                return Date::class;
            }
            if( $object instanceof Number ) {
                return Number::class;
            }
        }

        return ($allowString ? self::getTypeOfString($object, $allowLooseString) : null);
    }

    /**
     * @param $input
     * @param null $default
     * @param bool $allowLooseString
     * @return string|null
     */
    public static function getTypeOfString($input, $default = null, $allowLooseString = true) {
        if( is_string($input) ) {
            $tmp_input = trim($input);

            if( in_array($tmp_input, [Currency::class, Date::class, Number::class]) ) {
                return $tmp_input;
            }

            if( $allowLooseString ) {
                //$tmp_input = strtolower($tmp_input);

                if( in_array($tmp_input, static::getModelCastsFor('currency')) ) {
                    return Currency::class;
                }

                if( in_array($tmp_input, static::getModelCastsFor('date')) ) {
                    return Date::class;
                }

                if( in_array($tmp_input, static::getModelCastsFor('number')) ) {
                    return Number::class;
                }
            }
        }

        return $default;
    }

    /**
     * Checks if $object is a localication type
     * @param mixed $object
     * @param bool $allowString
     * @param bool $allowLooseString
     * @return bool
     */
    public static function isType($object, $allowString = true, $allowLooseString = true):bool {
        return (self::getTypeOf($object, $allowString, $allowLooseString) !== null);
    }

    /**
     * Checks if $input is a string representing a localication type
     * @param $input
     * @param bool $allowLooseString
     * @return bool
     */
    public static function isTypeString($input, $allowLooseString = true):bool {
        return (self::getTypeOfString($input, $allowLooseString) !== null);
    }
}