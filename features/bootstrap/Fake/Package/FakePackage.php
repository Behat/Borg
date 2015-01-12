<?php

namespace Fake\Package;

use Behat\Borg\Package\Package;

final class FakePackage implements Package
{
    private $name;

    public static function named($name)
    {
        if (2 !== count(explode('/', $name))) {
            throw new \InvalidArgumentException('Package should include organisation and name.');
        }

        $package = new FakePackage();
        $package->name = $name;

        return $package;
    }

    public function getOrganisationName()
    {
        return explode('/', $this->name)[0];
    }

    public function getName()
    {
        return explode('/', $this->name)[1];
    }

    public function __toString()
    {
        return $this->name;
    }

    private function __construct() { }
}
