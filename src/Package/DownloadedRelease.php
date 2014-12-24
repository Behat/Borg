<?php

namespace Behat\Borg\Package;

use DateTimeImmutable;

/**
 * Represents a downloaded release.
 */
interface DownloadedRelease
{
    /**
     * @return Release
     */
    public function getRelease();

    /**
     * @return DateTimeImmutable
     */
    public function getReleaseTime();
}
