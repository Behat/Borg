<?php

namespace Behat\Borg\Package\Documentation;

use Behat\Borg\Package\Finder\PackageFinder;
use Behat\Borg\Release\Downloader\Download;

/**
 * Finds borg.json-based package information in the download.
 */
final class DocumentationPackageFinder implements PackageFinder
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

        return new DocumentationPackage($meta['for-package']);
    }
}
