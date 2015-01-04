<?php

namespace Behat\Borg\ComposerPackage;

use Behat\Borg\Package\Finder\PackageFinder;
use Behat\Borg\Release\Downloader\Download;

/**
 * Finds composer package ID in provided release download.
 */
final class ComposerPackageFinder implements PackageFinder
{
    /**
     * {@inheritdoc}
     */
    public function findPackage(Download $download)
    {
        if (!$download->hasFile('composer.json')) {
            return null;
        }

        $meta = json_decode(file_get_contents($download->getFilePath('composer.json')), true);

        return new ComposerPackage($meta['name']);
    }
}
