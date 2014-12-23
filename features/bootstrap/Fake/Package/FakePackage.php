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
        if (2 !== count(explode('/', $name))) {
            throw new \InvalidArgumentException('Package should include organisation and name.');
        }

        $package = new FakePackage();
        $package->name = $name;

        return $package;
    }

    /**
     * @return string
     */
    public function getOrganisation()
    {
        return explode('/', $this->name)[0];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return explode('/', $this->name)[1];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    private function __construct(){}
}
