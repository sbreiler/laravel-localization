<?php namespace sbreiler\Localization\Type;

use \NumberFormatter;

class Number extends NumberFormatter {
    /** @var float */
    protected $value = 0;

    /**
     * @param string $locale
     * @param int $style
     * @param string|null $pattern
     * @return self
     */
    public static function create($locale, $style = NumberFormatter::DECIMAL, $pattern = null) {
        $res = new self($locale, $style);
        // TODO: pattern is by NumberFormatter ignored?!
        /*
        if( true === is_string($pattern) ) {
            var_dump($pattern);
            $res->setPattern($pattern);
        }
        */
        return $res;
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
     * @return string
     */
    public function __toString() {
        return (string)$this->format($this->value);
    }
}