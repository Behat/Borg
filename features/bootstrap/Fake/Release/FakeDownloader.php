<?php

namespace Fake\Release;

use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Downloader\Downloader;
use Behat\Borg\Release\Release;
use DateTimeImmutable;

final class FakeDownloader implements Downloader
{
    private $downloads;

    public function addReleaseDownload(Release $release, Download $download)
    {
        $this->downloads[(string)$release] = $download;
    }

    public function download(Release $release)
    {
        if (isset($this->downloads[(string)$release])) {
            return $this->downloads[(string)$release];
        }

        return new FakeDownload($release, new DateTimeImmutable());
    }
}
