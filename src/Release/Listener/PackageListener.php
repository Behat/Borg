<?php

namespace Behat\Borg\Release\Listener;

use Behat\Borg\Release\Downloader\DownloadedPackage;

/**
 * Listens to package release events.
 */
interface PackageListener
{
    /**
     * Notifies listeners that package was downloaded.
     *
     * @param DownloadedPackage $downloadedPackage
     */
    public function packageDownloaded(DownloadedPackage $downloadedPackage);
}
