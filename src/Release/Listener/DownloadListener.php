<?php

namespace Behat\Borg\Release\Listener;

use Behat\Borg\Release\Downloader\Download;

/**
 * Listens to release download events.
 */
interface DownloadListener
{
    /**
     * Notifies listener about successful release download.
     *
     * @param Download $download
     */
    public function releaseWasDownloaded(Download $download);
}
