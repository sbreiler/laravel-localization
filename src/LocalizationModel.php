<?php namespace sbreiler\Localization;

use \Illuminate\Database\Eloquent\Model;

use sbreiler\Localization\Type\Currency;
use sbreiler\Localization\Type\Number;
use sbreiler\Localization\Type\Date;

class LocalizationModel extends Model {
    protected $localize = [];

    /**
     * overrides method on model class
     * @param string $key
     * @return mixed|string
     */
    public function getAttributeValue($key) {
        if( $this->hasLocalizaion($key) ) {
            return $this->getCastedObject($key);
        }

        return parent::getAttributeValue($key);
    }

    public function setAttribute($key, $value) {
        if( $this->hasLocalizaion($key) ) {
            if( is_object($value) ) {
                $value = $value->getValue();
            }
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * @param $key
     * @return bool
     */
    protected function hasLocalizaion($key) {
        if(
            (false === isset($this->localize)) ||
            (false === is_array($this->localize))
        ) {
            return false;
        }

        return array_key_exists($key, $this->localize);
    }

    protected function getCastedObject($key) {
        $settings = $this->localize[$key];

        switch($settings['type']) {
            case Currency::class:
                $currency = Localization::currency(parent::getAttributeValue($key));

                if( array_key_exists('currency', $settings) ) {
                    $currency->setCurrencyCode($settings['currency']);
                }

                return $currency;

            case Number::class:
                return Localization::number(parent::getAttributeValue($key));
        }

        return null;
    }
}