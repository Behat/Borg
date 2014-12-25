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

    /**
     * @return string
     */
    public function getPath();

    /**
     * @param string $relativePath
     *
     * @return Boolean
     */
    public function hasFile($relativePath);
}
