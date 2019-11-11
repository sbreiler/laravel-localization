<?php namespace sbreiler\Localization;

use \Illuminate\Database\Eloquent\Model;

use sbreiler\Localization\Helpers;

class LocalizationModel extends Model {
    protected $localize = [];

    /**
     * overrides method on model class
     * @param string $key
     * @return ..\Type\Number|..\Type\Date|..\Type\Currency|mixed
     */
    public function getAttributeValue($key) {
        if( $this->hasLocalization($key) ) {
            return Helper::castValueTo(
                parent::getAttributeValue($key),
                $this->getLocalize($key)
            );
        }

        return parent::getAttributeValue($key);
    }

    public function setAttribute($key, $value) {
        if( $this->hasLocalization($key) ) {
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
    protected function hasLocalization($key) {
        if(
            (false === isset($this->localize)) ||
            (false === is_array($this->localize))
        ) {
            return false;
        }

        return array_key_exists($key, $this->localize);
    }
}