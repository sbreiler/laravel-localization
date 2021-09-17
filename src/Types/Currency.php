<?php namespace sbreiler\Localization\Types;

use \NumberFormatter;
use sbreiler\Localization\Contracts\Type as ContractType;
use sbreiler\Localization\Helpers\Config;

class Currency extends BaseNumber implements ContractType {
    const DEFAULT_CURRENCY_CODE = 'USD';

    protected static $CONFIG_DEFAULT_CURRENCY_CODE = null;

    /** @var float */
    protected $value = 0;
    /** @var string */
    protected $currency_code = self::DEFAULT_CURRENCY_CODE; //The 3-letter ISO 4217 currency code indicating the currency to use.

    /**
    * @param string $locale
    * @param string $currency_code
    * @param string|null $pattern
    * @return Currency
    */
    public static function create($locale, $currency_code = null, $pattern = null) {
        return
            (new self($locale, NumberFormatter::CURRENCY, $pattern))
                ->setCurrencyCode($currency_code)
        ;
    }

    /**
     * @param string|null $code
     * @return $this
     */
    public function setCurrencyCode($code) {
        $this->currency_code =
            is_null($code)
            ? null
            : substr(strtoupper($code),0,3)
        ;

        return $this;
    }

    protected static function getDefaultCurrencyCode() {
        if( null === self::$CONFIG_DEFAULT_CURRENCY_CODE ) {
            self::$CONFIG_DEFAULT_CURRENCY_CODE = Config::get('currency.default_currency_code', self::DEFAULT_CURRENCY_CODE, false);
        }

        return self::$CONFIG_DEFAULT_CURRENCY_CODE;
    }

    /**
    * @return string
    */
    public function __toString(): string {
        return (string)$this->formatCurrency(
            $this->value,
            $this->currency_code ?? self::getDefaultCurrencyCode()
        );
    }
}