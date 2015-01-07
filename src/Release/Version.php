<?php

namespace Behat\Borg\Release;

use Behat\Borg\Release\Exception\BadVersionStringGiven;

/**
 * Represents software package version.
 */
final class Version
{
    private $versionString;
    private $major;
    private $minor;
    private $patch;
    private $branchName;

    /**
     * Constructs version from a string.
     *
     * @param string $string
     *
     * @return Version
     *
     * @throws BadVersionStringGiven
     */
    public static function string($string)
    {
        if (in_array($string, ['master', 'develop'])) {
            $version = new Version();
            $version->versionString = $string;
            $version->branchName = $string;

            return $version;
        }

        if (!preg_match('/^[vV]?+(\d++)\.(\d++)(?:\.(\d++.*+|x))?$/', $string, $matches)) {
            throw new BadVersionStringGiven("`{$string}` is not a supported version string.");
        }

        $version = new Version();
        $version->versionString = $string;
        $version->major = $matches[1];
        $version->minor = $matches[2];
        $version->patch = isset($matches[3]) ? $matches[3] : 'x';

        return $version;
    }

    /**
     * Returns major version string without the leading "v".
     *
     * @return null|string
     */
    public function getMajor()
    {
        return $this->isBranch() ? null : $this->major;
    }

    /**
     * Returns minor version string without the leading "v".
     *
     * @return null|string
     */
    public function getMinor()
    {
        return $this->isBranch() ? null : sprintf('%d.%d', $this->major, $this->minor);
    }

    /**
     * Returns patch version string without the leading "v".
     *
     * @return null|string
     */
    public function getPatch()
    {
        return $this->isBranch() ? null : sprintf('%d.%d.%s', $this->major, $this->minor, $this->patch);
    }

    /**
     * Returns branch name if version is a branch.
     *
     * @return null|string
     */
    public function getBranchName()
    {
        return $this->branchName;
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
     * Checks if version is stable.
     *
     * @return Boolean
     */
    public function isStable()
    {
        return is_numeric($this->patch);
    }

    /**
     * Checks if version is a branch.
     *
     * @return Boolean
     */
    public function isBranch()
    {
        return null !== $this->branchName;
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
