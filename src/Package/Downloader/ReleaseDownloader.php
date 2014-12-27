<?php

namespace Behat\Borg\Package\Downloader;

use Behat\Borg\Package\Release;

/**
 * Represents a mechanism do download releases.
 */
interface ReleaseDownloader
{
    /**
     * Downloads provided release.
     *
     * @param Release $release
     *
     * @return Download
     */
    public function downloadRelease(Release $release);
}
