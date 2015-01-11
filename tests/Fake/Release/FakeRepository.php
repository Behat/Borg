<?php

namespace tests\Behat\Borg\Fake\Release;

use Behat\Borg\Release\Repository;

final class FakeRepository implements Repository
{
    private $name;

    public static function named($name)
    {
        if (2 !== count(explode('/', $name))) {
            throw new \InvalidArgumentException('Package should include organisation and name.');
        }

        $package = new FakeRepository();
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

    private function __construct(){}
}
