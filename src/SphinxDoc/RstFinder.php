<?php

namespace Behat\Borg\SphinxDoc;

use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Release\Downloader\Download;

/**
 * Tries to find if the download has rst documentation.
 */
final class RstFinder implements SourceFinder
{
    /**
     * {@inheritdoc}
     */
    public function findSource(Download $download)
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
