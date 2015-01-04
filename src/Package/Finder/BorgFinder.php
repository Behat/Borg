<?php

namespace Behat\Borg\Package\Finder;

use Behat\Borg\Package\BorgPackage;
use Behat\Borg\Release\Downloader\Download;

/**
 * Finds borg.json-based package information in the download.
 */
final class BorgFinder implements PackageFinder
{
    /**
     * {@inheritdoc}
     */
    public function findPackage(Download $download)
    {
        if (!$download->hasFile('borg.json')) {
            return null;
        }

        $meta = json_decode(file_get_contents("{$download->getPath()}/borg.json"), true);

        return new BorgPackage($meta['for-package']);
    }
}
