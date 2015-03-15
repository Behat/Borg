<?php

namespace Fake\Release;

use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\PackageFinder\PackageFinder;

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
