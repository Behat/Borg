<?php

namespace Behat\Borg\Documentation\Finder;

use Behat\Borg\Package\Downloader\DownloadedRelease;

interface DocumentationFinder
{
    public function findDocumentation(DownloadedRelease $downloadedRelease);
}
