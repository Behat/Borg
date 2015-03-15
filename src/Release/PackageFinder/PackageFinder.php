<?php

namespace Behat\Borg\Release\PackageFinder;

use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Package;

/**
 * Finds packages in provided release downloads.
 */
interface PackageFinder
{
    /**
     * Tries to find a package inside release download.
     *
     * @param Download $download
     *
     * @return null|Package
     */
    public function find(Download $download);
}
