<?php namespace sbreiler\Localization\Types;

use \NumberFormatter;
use sbreiler\Localization\Contracts\Type as ContractType;

/**
 * Class Number
 * @method string|false getPattern()
 */
class Number extends BaseNumber implements ContractType {
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
     * @return string
     */
    public function __toString() {
        return (string)$this->format($this->value);
    }
}