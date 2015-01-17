<?php

namespace Behat\Borg\Release\Downloader;

use Behat\Borg\Release\Exception\FileNotFound;
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
    public function version();

    /**
     * Returns release time.
     *
     * @return DateTimeImmutable
     */
    public function releasedAt();

    /**
     * Returns path to downloaded release.
     *
     * @return string
     */
    public function path();

    /**
     * Checks if downloaded release has provided file.
     *
     * @param string $relativePath
     *
     * @return Boolean
     */
    public function hasFile($relativePath);

    /**
     * Returns absolute path to the file of relative path.
     *
     * @param string $relativePath
     *
     * @return string
     *
     * @throws FileNotFound
     */
    public function filePath($relativePath);
}
