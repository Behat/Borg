<?php

namespace Behat\Borg\Documentation\Finder;

use Behat\Borg\Documentation\Source;
use Behat\Borg\Package\Downloader\Download;

/**
 * Finds documentation source in provided downloaded release.
 */
interface SourceFinder
{
    /**
     * Tries to find documentation source in provided download.
     *
     * @param Download $download
     *
     * @return null|Source
     */
    public function findDocumentationSource(Download $download);
}
