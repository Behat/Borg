<?php

namespace Behat\Borg\Integration\Release\Composer;

use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\PackageFinder\PackageFinder;

/**
 * Finds composer package ID in provided release download.
 */
final class ComposerPackageFinder implements PackageFinder
{
    /**
     * {@inheritdoc}
     */
    public function find(Download $download)
    {
        if (!$download->hasFile('composer.json')) {
            return null;
        }

        $path = $download->filePath('composer.json');
        $meta = json_decode(file_get_contents($path), true);

        return new ComposerPackage($meta);
    }
}
