<?php namespace sbreiler\Localization\Types;

use \NumberFormatter;

class BaseNumber extends Base {
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
     * @param integer $value
     * @return $this
     */
    public function precision($value) {
        return $this->setAttribute(NumberFormatter::FRACTION_DIGITS, $value);
    }

    /**
     * @param integer $value
     * @return $this
     */
    public function precisionMin($value) {
        return $this->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $value);
    }

    /**
     * @param integer $value
     * @return $this
     */
    public function precisionMax($value) {
        return $this->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, $value);
    }

    /**
     * @param int $precision
     * @param int $mode
     * @return $this
     */
    public function round($precision = 0, $mode = NumberFormatter::ROUND_HALFUP) {
        $this->setAttribute(NumberFormatter::ROUNDING_MODE, $mode);

        return $this->precision($precision);
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
}