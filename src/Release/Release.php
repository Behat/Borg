<?php

namespace Behat\Borg\Release;

/**
 * Represents software package release.
 */
final class Release
{
    /**
     * @var Repository
     */
    private $repository;
    /**
     * @var Version
     */
    private $version;

    /**
     * Initializes release.
     *
     * @param Repository $repository
     * @param Version    $version
     */
    public function __construct(Repository $repository, Version $version)
    {
        $this->repository = $repository;
        $this->version = $version;
    }

    /**
     * Returns release repository.
     *
     * @return Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Returns release version.
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
        return sprintf('%s/%s', $this->repository, $this->version);
    }
}
