<?php namespace sbreiler\Localization\Types;

use \NumberFormatter;

class Base extends NumberFormatter {
    /**
     * Overwrite internal setAttribute to return $this
     * @param int $attribute
     * @param int $value
     * @return $this
     */
    public function setAttribute($attribute, $value) {
        parent::setAttribute($attribute, $value);

        return $this;
    }
}