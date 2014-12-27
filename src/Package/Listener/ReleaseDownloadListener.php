<?php

namespace Behat\Borg\Package\Listener;

use Behat\Borg\Package\Downloader\DownloadedRelease;

/**
 * Listens to release download events.
 */
interface ReleaseDownloadListener
{
    /**
     * Notifies listener about successful release download.
     *
     * @param DownloadedRelease $downloadedRelease
     */
    public function releaseWasDownloaded(DownloadedRelease $downloadedRelease);
}
