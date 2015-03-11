<?php

namespace Fake\Extension;

use Behat\Borg\Extension\Extension;
use Behat\Borg\Package\Package;

final class FakeExtension implements Extension, Package
{
    private $name;

    public static function named($name)
    {
        if (2 !== count(explode('/', $name))) {
            throw new \InvalidArgumentException('Extension should include organisation and name.');
        }

        $package = new FakeExtension();
        $package->name = $name;

        return $package;
    }

    public function organisationName()
    {
        return explode('/', $this->name)[0];
    }

    public function name()
    {
        return explode('/', $this->name)[1];
    }

    public function __toString()
    {
        return $this->name;
    }

    private function __construct() { }
}
