<?php

namespace Behat\Borg\Release;

/**
 * Represents software package release.
 */
final class Release
{
    private $package;
    private $version;

    /**
     * Initializes release.
     *
     * @param Repository $package
     * @param Version $version
     */
    public function __construct(Repository $package, Version $version)
    {
        $this->package = $package;
        $this->version = $version;
    }

    /**
     * Returns package instance.
     *
     * @return Repository
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Returns package version.
     *
     * @return Version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Returns string representation of release.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->package, $this->version);
    }
}
