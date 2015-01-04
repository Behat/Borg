<?php

namespace Behat\Borg\Package\Finder;

use Behat\Borg\Package\Package;
use Behat\Borg\Release\Downloader\Download;

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
    public function findPackage(Download $download);
}
