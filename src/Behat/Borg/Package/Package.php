<?php

namespace Behat\Borg\Package;

final class Package
{
    private $name;

    private function __construct($name)
    {
        $this->name = $name;
    }

    public static function fromName($name)
    {
        return new self($name);
    }

    public function getName()
    {
        return $this->name;
    }
}
