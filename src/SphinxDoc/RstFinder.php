<?php

namespace Behat\Borg\SphinxDoc;

use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Package\Downloader\Download;

final class RstFinder implements SourceFinder
{
    public function findDocumentationSource(Download $download)
    {
        if ($download->hasFile('index.rst')) {
            return Rst::atPath($download->getPath());
        }

        if ($download->hasFile('doc/index.rst')) {
            return Rst::atPath($download->getPath() . '/doc');
        }

        return null;
    }
}
