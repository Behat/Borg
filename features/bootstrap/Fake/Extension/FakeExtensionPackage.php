<?php

namespace Fake\Extension;

use Behat\Borg\Extension\Extension;
use Behat\Borg\Release\Package;

final class FakeExtensionPackage implements Package
{
    private $parts;

    public static function named($name)
    {
        $parts = explode('/', $name);

        if (2 !== count($parts)) {
            throw new \InvalidArgumentException('Extension should include organisation and name.');
        }

        $package = new FakeExtensionPackage();
        $package->parts = $parts;

        return $package;
    }

    public function organisationName()
    {
        return $this->parts[0];
    }

    public function name()
    {
        return $this->parts[1];
    }

    public function __toString()
    {
        return implode('/', $this->parts);
    }

    public function extension()
    {
        return new Extension($this->organisationName(), $this->name(), 'some package', 'anonymous');
    }

    private function __construct() { }
}
