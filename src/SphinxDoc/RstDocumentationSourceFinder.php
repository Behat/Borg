<?php

namespace Behat\Borg\SphinxDoc;

use Behat\Borg\Documentation\Finder\DocumentationSourceFinder;
use Behat\Borg\Package\Downloader\Download;

final class RstDocumentationSourceFinder implements DocumentationSourceFinder
{
    public function findDocumentationSource(Download $download)
    {
        if ($download->hasFile('index.rst')) {
            return RstDocumentationSource::atPath($download->getPath());
        }

        if ($download->hasFile('doc/index.rst')) {
            return RstDocumentationSource::atPath($download->getPath() . '/doc');
        }

        return null;
    }
}
