<?php

/**
 * @property string $signature
 * @property string $host
 * @property string $database
 * @property string $user
 * @property string $password
 */
class RepositoryProperties {
    public array $properties = array();

    function __construct(string $signature, string $host, string $database,
                         string $user, string $password) {
        $this->properties['signature'] = $signature;
        $this->properties['host'] = $host;
        $this->properties['database'] = $database;
        $this->properties['user'] = $user;
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