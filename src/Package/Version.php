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
        $version = new Version();
        $version->versionString = $string;

        return $version;
    }

    /**
     * Returns string representation of version.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->versionString;
    }

    private function __construct() { }
}
