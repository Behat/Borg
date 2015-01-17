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
    public function find(Download $download)
    {
        if ($download->hasFile('index.rst')) {
            return Rst::atPath($download->path());
        }

        if ($download->hasFile('doc/index.rst')) {
            return Rst::atPath($download->filePath('doc'));
        }

        return null;
    }
}
