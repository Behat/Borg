<?php

namespace Behat\Borg\Package;

/**
 * Represents software package.
 */
final class Package
{
    private $name;

    /**
     * Constructs software package from name.
     *
     * @param string $name
     *
     * @return Package
     */
    public static function named($name)
    {
        return new self($name);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    private function __construct($name)
    {
        $this->name = $name;
    }
}
