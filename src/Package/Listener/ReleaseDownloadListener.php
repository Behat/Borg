<?php

namespace Behat\Borg\Package\Listener;

use Behat\Borg\Package\Downloader\Download;

/**
 * Listens to release download events.
 */
interface ReleaseDownloadListener
{
    /**
     * Notifies listener about successful release download.
     *
     * @param Download $download
     */
    public function releaseWasDownloaded(Download $download);
}
