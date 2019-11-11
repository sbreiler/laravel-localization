<?php namespace sbreiler\Localization\Contracts;

interface Type {
    /**
     * @param $value
     * @return self
     */
    public function setValue($value);

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return string
     */
    public function __toString();
}