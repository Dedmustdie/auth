<?php

/**
 * @property string $key
 * @property string $iss
 * @property string $aud
 * @property string $iat
 * @property string $nbf
 */
class JWTProperties {
    public array $properties = array();

    function __construct(string $key, string $iss, string $aud,
                         string $iat, string $nbf) {
        $this->properties['key'] = $key;
        $this->properties['iss '] = $iss;
        $this->properties['aud'] = $aud;
        $this->properties['iat'] = $iat;
        $this->properties['nbf '] = $nbf;
    }

    public function __get($propertyName)
    {
        if (array_key_exists($propertyName, $this->properties)) {
            return $this->properties[$propertyName];
        }
        return null;
    }

    public function __set($propertyName, $value)
    {
        $this->properties[$propertyName] = $value;
    }
}