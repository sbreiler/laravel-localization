<?php namespace sbreiler\Localization\Types;

use \IntlDateFormatter;
use \DateTime;
use \Carbon\Carbon; // todo: newer version available?
use sbreiler\Localization\Contracts\Type as ContractType;

class Date /*extends \IntlDateFormatter*/ implements ContractType {
    const FORMATS = [
        'FULL' => IntlDateFormatter::FULL,
        'LONG' => IntlDateFormatter::LONG,
        'MEDIUM' => IntlDateFormatter::MEDIUM,
        'SHORT' => IntlDateFormatter::SHORT,
        'NONE' => IntlDateFormatter::NONE
    ];
    const DEFAULT_FORMAT = self::FORMATS['NONE'];

    /** @var DateTime */
    protected $value = null;

    protected $locale = null;
    /** @var int */
    protected $datetype = self::DEFAULT_FORMAT;
    /** @var int */
    protected $timetype = self::DEFAULT_FORMAT;
    protected $timezone = null;
    protected $calendar = null;
    protected $pattern = null;

    public function __construct($locale = null, $datetype = self::DEFAULT_FORMAT, $timetype = self::DEFAULT_FORMAT, $value = null) {
        $this->setLocale($locale)
            ->setDateType($datetype)
            ->setTimeType($timetype)
            ->setValue($value);
    }

    public static function create($locale = null, $datetype = self::DEFAULT_FORMAT, $timetype = self::DEFAULT_FORMAT, $value = null) {
        return new self($locale, $datetype, $timetype, $value);
    }

    /**
     * @param $value
     * @return DateTime
     */
    protected static function checkDateType($value) {
        if( true === is_string($value) ) {
            return new DateTime($value);
        }

        if( true === is_numeric($value) ) {
            // could be timestamp?!
            return (new DateTime())->setTimestamp((int)$value);
        }

        return $value;
    }

    /**
     * @param null|string $locale
     * @return $this
     */
    public function setLocale($locale = null) {
        if( null === $locale ) {
            // use standard
            $locale = Format::getLocalPHP();
        }

        $this->locale = $locale;

        return $this;
    }

    /**
     * @param int $datetype
     * @return $this
     */
    public function setDateType($datetype) {
        $this->datetype = $datetype;

        return $this;
    }

    /**
     * @param int $timetype
     * @return $this
     */
    public function setTimeType($timetype) {
        $this->timetype = $timetype;

        return $this;
    }

    /**
     * @param string|DateTime $value
     * @return Date
     */
    public function setValue($value) {
        $this->value = self::checkDateType($value);

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getValue() {
        return $this->value;
    }

    public function asShortDate() {
        return $this
            ->setDateType(IntlDateFormatter::SHORT)
            ->setTimeType(IntlDateFormatter::NONE);
    }

    public function asMediumDate() {
        return $this
            ->setDateType(IntlDateFormatter::MEDIUM)
            ->setTimeType(IntlDateFormatter::NONE);
    }

    public function asLongDate() {
        return $this
            ->setDateType(IntlDateFormatter::LONG)
            ->setTimeType(IntlDateFormatter::NONE);
    }

    public function asFullDate() {
        return $this
            ->setDateType(IntlDateFormatter::FULL)
            ->setTimeType(IntlDateFormatter::NONE);
    }

    public function asShortTime() {
        return $this
            ->setDateType(IntlDateFormatter::NONE)
            ->setTimeType(IntlDateFormatter::SHORT);
    }

    public function asMediumTime() {
        return $this
            ->setDateType(IntlDateFormatter::NONE)
            ->setTimeType(IntlDateFormatter::MEDIUM);
    }

    public function asLongTime() {
        return $this
            ->setDateType(IntlDateFormatter::NONE)
            ->setTimeType(IntlDateFormatter::LONG);
    }

    public function asFullTime() {
        return $this
            ->setDateType(IntlDateFormatter::NONE)
            ->setTimeType(IntlDateFormatter::FULL);
    }

    /**
     * @param Carbon|Date $other
     * @param bool $absolute
     * @param bool $short
     * @return string
     */
    public function diffForHumans($other = null, $absolute = false, $short = false) {
        if( $other instanceof self ) {
            $other = $other->getValue();
        }

        return Carbon::instance($this->getValue())->diffForHumans($other, $absolute, $short);
    }

    /**
     * @return string
     */
    public function format() {
        $fmt = datefmt_create($this->locale, $this->datetype, $this->timetype, $this->timezone, $this->calendar, $this->pattern);

        return datefmt_format($fmt, $this->value);
    }

    /**
     * @return string
     */
    public function __toString() {
        return (string)$this->format();
    }
}