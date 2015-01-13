<?php

namespace Behat\Borg\PackageDocumentation;

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
    public function findPackage(Download $download)
    {
        if (!$download->hasFile('borg.json')) {
            return null;
        }

        $path = $download->getFilePath('borg.json');
        $meta = json_decode(file_get_contents($path), true);

        return new DocumentationPackage($meta['for-package']);
    }
}
