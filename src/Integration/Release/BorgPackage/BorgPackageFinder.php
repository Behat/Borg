<?php

namespace Behat\Borg\Integration\Release\BorgPackage;

use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\PackageFinder\PackageFinder as PackageFinderInterface;

/**
 * Finds borg.json-based package information in the download.
 */
final class BorgPackageFinder implements PackageFinderInterface
{
    /**
     * {@inheritdoc}
     */
    public function find(Download $download)
    {
        if (!$download->hasFile('borg.json')) {
            return null;
        }

        $path = $download->filePath('borg.json');
        $meta = json_decode(file_get_contents($path), true);

        return new BorgPackage($meta['for-package']);
    }
}
