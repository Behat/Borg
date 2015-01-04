<?php

namespace Fake\Release;

use Behat\Borg\Documentation\Source;
use Behat\Borg\Release\Downloader\Downloader;
use Behat\Borg\Release\Release;
use DateTimeImmutable;

final class FakeDownloader implements Downloader
{
    private $downloads;

    public function releaseWasDocumented(Release $release, DateTimeImmutable $time, Source $source)
    {
        $this->downloads[(string)$release] = new FakeDownload($release, $time, $source);
    }

    public function download(Release $release)
    {
        if (isset($this->downloads[(string)$release])) {
            return $this->downloads[(string)$release];
        }

        return new FakeDownload($release, new DateTimeImmutable());
    }
}
