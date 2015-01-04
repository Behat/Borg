<?php

namespace Behat\Borg\Release\Downloader;

use Behat\Borg\Filesystem\Directory;
use Behat\Borg\Release\Version;
use DateTimeImmutable;

/**
 * Represents a release download.
 */
interface Download extends Directory
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
}
