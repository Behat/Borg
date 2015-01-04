<?php

namespace Fake\Release;

use Behat\Borg\Release\Package;

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

    public function getOrganisation()
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

    private function __construct(){}
}
