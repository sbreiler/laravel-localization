<?php namespace sbreiler\Localization\Traits;

use sbreiler\Localization\Helpers;
use sbreiler\Localization\Localization;

trait HasLocalization {

    /**
     * @param string $key
     * @return ..\Type\Number|..\Type\Date|..\Type\Currency|mixed
     */
    public function getAttribute($key) {
        if( $this->hasLocalization($key) ) {
            return self::getAttributeValue($key);
        }

        return parent::getAttribute($key);
    }

    /**
     * @param $key
     * @return ..\Type\Number|..\Type\Date|..\Type\Currency|mixed
     */
    public function getAttributeValue($key) {
        if( $this->hasLocalization($key) ) {
            return Helpers\Type::castModelValueTo(
                parent::getAttributeValue($key),
                $this->getLocalize($key)
            );
        }

        return parent::getAttributeValue($key);
    }

    public function setAttribute($key, $value) {
        if( $this->hasLocalization($key) ) {
            $this->attributes[$key] = $value;

            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * @param null|string $key if set, return specific element, otherwise return all
     * @param null $defaultValue if key is not found, this value is returned
     * @return array|mixed|null
     */
    public function getLocalize($key = null, $defaultValue = null) {
        $localize = (isset($this->localize) && is_array($this->localize)) ? $this->localize : [];

        if( null === $key ) {
            return $localize;
        }

        return array_key_exists($key, $localize) ? $localize[$key] : $defaultValue;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasLocalization($key) {
        return array_key_exists($key, $this->getLocalize());
    }
}