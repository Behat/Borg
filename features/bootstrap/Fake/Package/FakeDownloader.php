<?php

namespace Fake\Package;

use Behat\Borg\Package\Downloader\Downloader;
use Behat\Borg\Package\Release;

final class FakeDownloader implements Downloader
{
    public function downloadRelease(Release $release)
    {
        return new FakeDownload($release);
    }
}
