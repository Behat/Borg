<?php

namespace Fake\Package;

use Behat\Borg\Package\Downloader\ReleaseDownloader;
use Behat\Borg\Package\Release;

final class FakeReleaseDownloader implements ReleaseDownloader
{
    public function downloadRelease(Release $release)
    {
        return new FakeDownloadedRelease($release);
    }
}
