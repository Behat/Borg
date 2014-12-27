<?php

namespace Behat\Borg\Package\Downloader;

use Behat\Borg\Package\Release;
use DateTimeImmutable;

/**
 * Represents a downloaded release.
 */
interface DownloadedRelease
{
    /**
     * Returns a release that been downloaded.
     *
     * @return Release
     */
    public function getRelease();

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
