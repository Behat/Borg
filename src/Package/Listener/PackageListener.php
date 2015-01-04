<?php

namespace Behat\Borg\Package\Listener;

use Behat\Borg\Package\PackageDownload;

/**
 * Listens to package release events.
 */
interface PackageListener
{
    /**
     * Notifies listeners that package was downloaded.
     *
     * @param PackageDownload $packageDownload
     */
    public function packageWasDownloaded(PackageDownload $packageDownload);
}
