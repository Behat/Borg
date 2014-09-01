<?php

namespace Behat\Borg\Package;

/**
 * Represents software package version.
 */
final class Version
{
    private $versionString;

    /**
     * Constructs version from a string.
     *
     * @param string $string
     *
     * @return Version
     */
    public static function string($string)
    {
        return new self($string);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->versionString;
    }

    private function __construct($versionString)
    {
        $this->versionString = $versionString;
    }
}
