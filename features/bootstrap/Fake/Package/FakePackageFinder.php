<?php

namespace Fake\Package;

use Behat\Borg\Package\Finder\PackageFinder;
use Behat\Borg\Release\Downloader\Download;

final class FakePackageFinder implements PackageFinder
{
    public function find(Download $download)
    {
        if ($download instanceof PackageDownload) {
            return $download->package();
        }

        return null;
    }
}
