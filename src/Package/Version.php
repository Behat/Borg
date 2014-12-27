<?php

namespace Behat\Borg\Package;

/**
 * Represents software package version.
 */
final class Version
{
    private $versionString;
    private $major;
    private $minor;
    private $patch;

    /**
     * Constructs version from a string.
     *
     * @param string $string
     *
     * @return Version
     */
    public static function string($string)
    {
        if (!preg_match('/^[vV]?(\d+)\.(\d+)(?:\.(\d+.*))?$/', $string, $matches)) {
            throw new \InvalidArgumentException("Invalid Version string provided: $string.");
        }

        $version = new Version();
        $version->versionString = $string;
        $version->major = $matches[1];
        $version->minor = $matches[2];
        $version->patch = isset($matches[3]) ? $matches[3] : '';

        return $version;
    }

    /**
     * Returns major version string without the leading "v".
     *
     * @return string
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * Returns minor version string without the leading "v".
     *
     * @return string
     */
    public function getMinor()
    {
        return sprintf('%d.%d', $this->major, $this->minor);
    }

    /**
     * Returns patch version string without the leading "v".
     *
     * @return string
     */
    public function getPatch()
    {
        return sprintf('%d.%d.%s', $this->major, $this->minor, $this->patch);
    }

    /**
     * Returns canonical SemVer patch version string.
     *
     * @return string
     */
    public function getSemVer()
    {
        return sprintf('v%s', $this->getPatch());
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
