<?php

namespace Behat\Borg\SphinxDoc;

use Behat\Borg\Documentation\Finder\DocumentationSourceFinder;
use Behat\Borg\Package\Downloader\DownloadedRelease;

final class RstDocumentationSourceFinder implements DocumentationSourceFinder
{
    public function findDocumentationSource(DownloadedRelease $downloadedRelease)
    {
        if ($downloadedRelease->hasFile('index.rst')) {
            return RstDocumentationSource::atPath($downloadedRelease->getPath());
        }

        if ($downloadedRelease->hasFile('doc/index.rst')) {
            return RstDocumentationSource::atPath($downloadedRelease->getPath() . '/doc');
        }
    }
}
