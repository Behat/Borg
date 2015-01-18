<?php

namespace Behat\Borg\DocumentationPackage;

use Behat\Borg\Package\Finder\PackageFinder as PackageFinderInterface;
use Behat\Borg\Release\Downloader\Download;

/**
 * Finds borg.json-based package information in the download.
 */
final class DocumentationPackageFinder implements PackageFinderInterface
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

        return new DocumentationPackage($meta['for-package']);
    }
}
