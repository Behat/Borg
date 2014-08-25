<?php

namespace Behat\Borg\Package;

final class Version
{
    private $versionString;

    private function __construct($versionString)
    {
        $this->versionString = $versionString;
    }

    public static function fromString($string)
    {
        return new self($string);
    }

    public function __toString()
    {
        return $this->versionString;
    }
}
