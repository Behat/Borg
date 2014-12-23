<?php

namespace Fake\Package;

use Behat\Borg\Package\Package;

final class FakePackage implements Package
{
    private $name;

    /**
     * Constructs software package from name.
     *
     * @param string $name
     *
     * @return self
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
