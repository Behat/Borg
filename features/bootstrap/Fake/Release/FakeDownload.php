<?php

namespace Fake\Release;

use Behat\Borg\Documentation\Source;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Release;
use DateTimeImmutable;

final class FakeDownload implements Download
{
    private $release;
    private $time;
    private $source;

    public function __construct(Release $release, DateTimeImmutable $time, Source $source = null)
    {
        $this->release = $release;
        $this->time = $time;
        $this->source = $source;
    }

    public function getRelease()
    {
        return $this->release;
    }

    public function getReleaseTime()
    {
        return $this->time;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getPath()
    {
        return __DIR__;
    }

    public function hasFile($relativePath)
    {
        return file_exists($this->getPath() . '/' . $relativePath);
    }
}
