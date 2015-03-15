<?php

namespace Behat\Borg\Package\Listener;

use Behat\Borg\Package\DownloadedPackage;

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
    public function packageWasDownloaded(DownloadedPackage $downloadedPackage);
}
