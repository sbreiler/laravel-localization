<?php namespace sbreiler\Localization\Type;

use \NumberFormatter;

class Currency extends NumberFormatter{
    /** @var float */
    protected $value = 0;
    /** @var string */
    protected $currency_code = 'USD'; //The 3-letter ISO 4217 currency code indicating the currency to use.

    /**
    * @param string $locale
    * @param int $style
    * @param string|null $pattern
    * @return Currency
    */
    public static function create($locale, $style = NumberFormatter::CURRENCY, $pattern = null) {
        return new self($locale, $style, $pattern);
    }

    /**
    * @param float $value
    * @return Currency
    */
    public function setValue($value) {
        $this->value = (float)$value;

        return $this;
    }

    /**
    * @return float
    */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCurrencyCode($code) {
        $this->currency_code = substr(strtoupper($code),0,3);

        return $this;
    }

    /**
    * @return string
    */
    public function __toString() {
        return (string)$this->formatCurrency($this->value, $this->currency_code);
    }
}