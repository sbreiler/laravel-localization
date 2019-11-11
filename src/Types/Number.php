<?php namespace sbreiler\Localization\Types;

use \NumberFormatter;
use sbreiler\Localization\Contracts\Type as ContractType;

/**
 * Class Number
 * @method string|false getPattern()
 */
class Number extends NumberFormatter implements ContractType {
    const STYLE = [
        'DECIMAL' => NumberFormatter::DECIMAL,
        'CURRENCY' => NumberFormatter::CURRENCY,
        'PERCENT' => NumberFormatter::PERCENT,
        'SCIENTIFIC' => NumberFormatter::SCIENTIFIC,
        'SPELLOUT' => NumberFormatter::SPELLOUT,
        'ORDINAL' => NumberFormatter::ORDINAL,
        'DURATION' => NumberFormatter::DURATION
    ];
    const DEFAULT_STYLE = self::STYLE['DECIMAL'];

    /** @var float */
    protected $value = 0;

    /**
     * @param string $locale
     * @param int $style
     * @param null|string $pattern
     * @return Number
     */
    public static function create($locale, $style = self::DEFAULT_STYLE, $pattern = null) {
        return new self($locale, $style, $pattern);
    }

    /**
     * @param float $value
     * @return $this
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
     * Set formatter pattern
     * @link https://php.net/manual/en/numberformatter.setpattern.php
     * @param string $pattern
     * @return $this
     * @throws \Exception
     */
    public function setPattern($pattern)
    {
        if( false === parent::setPattern($pattern) ) {
            throw new \Exception('Error on setting pattern');
        }

        return $this;
    }

    /**
     * @param int $precision
     * @param int $mode
     * @return $this
     */
    public function round($precision = 0, $mode = NumberFormatter::ROUND_HALFUP) {
        $this->setAttribute(NumberFormatter::ROUNDING_MODE, $mode);
        $this->setAttribute(NumberFormatter::FRACTION_DIGITS, $precision);

        return $this;
    }

    /**
     * @param int $precision
     * @return $this
     */
    public function floor($precision = 0) {
        return $this->round($precision, NumberFormatter::ROUND_FLOOR);
    }

    /**
     * @param int $precision
     * @return $this
     */
    public function ceil($precision = 0) {
        return $this->round($precision, NumberFormatter::ROUND_CEILING);
    }

    /**
     * @return string
     */
    public function __toString() {
        return (string)$this->format($this->value);
    }
}