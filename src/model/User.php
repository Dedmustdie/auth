<?php

/**
 * @property string $id
 * @property string $username
 * @property string $password
 */
class User {
    public array $properties = array();

    function __construct(string $id, string $username, string $password) {
        $this->properties['id'] = $id;
        $this->properties['username'] = $username;
        $this->properties['password'] = $password;
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