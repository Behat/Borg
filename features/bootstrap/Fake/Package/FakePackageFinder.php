<?php

namespace Fake\Package;

use Behat\Borg\Package\Finder\PackageFinder;
use Behat\Borg\Release\Downloader\Download;

final class FakePackageFinder implements PackageFinder
{
    public function findPackage(Download $download)
    {
        if ($download instanceof PackagedDownload) {
            return $download->getPackage();
        }

        return null;
    }
}
