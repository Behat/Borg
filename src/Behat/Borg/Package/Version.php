<?php

namespace Behat\Borg\Package;

final class Version
{
    private function __construct()
    {
    }

    public static function fromString($string)
    {
        return new self($string);
    }
}
