<?php

namespace Behat\Borg\Package;

final class Package
{
    private function __construct()
    {
    }

    public static function fromName($name)
    {
        return new self($name);
    }
}
