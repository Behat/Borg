<?php

namespace Behat\Borg\Release\Downloader;

use Behat\Borg\Release\Release;

/**
 * Represents a mechanism do download releases.
 */
interface Downloader
{
    /**
     * Downloads provided release.
     *
     * @param Release $release
     *
     * @return Download
     */
    public function download(Release $release);
}
