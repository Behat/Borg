<?php

namespace Behat\Borg\Documentation\Finder;

use Behat\Borg\Package\Downloader\DownloadedRelease;

interface DocumentationSourceFinder
{
    public function findDocumentationSource(DownloadedRelease $downloadedRelease);
}
