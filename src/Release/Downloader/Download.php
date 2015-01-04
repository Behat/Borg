<?php

namespace Behat\Borg\Release\Downloader;

use Behat\Borg\Release\Version;
use DateTimeImmutable;

/**
 * Represents a release download.
 */
interface Download
{
    /**
     * Returns downloaded version.
     *
     * @return Version
     */
    public function getVersion();

    /**
     * Returns release time.
     *
     * @return DateTimeImmutable
     */
    public function getReleaseTime();

    /**
     * Returns path to downloaded release.
     *
     * @return string
     */
    public function getPath();

    /**
     * Checks if downloaded release has provided file.
     *
     * @param string $relativePath
     *
     * @return Boolean
     */
    public function hasFile($relativePath);
}
