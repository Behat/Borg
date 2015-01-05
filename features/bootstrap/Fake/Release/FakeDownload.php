<?php

namespace Fake\Release;

use Behat\Borg\Release\Exception\FileNotFound;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Release;
use DateTimeImmutable;

final class FakeDownload implements Download
{
    private $release;
    private $time;

    public function __construct(Release $release, DateTimeImmutable $time)
    {
        $this->release = $release;
        $this->time = $time;
    }

    public function getVersion()
    {
        return $this->release->getVersion();
    }

    public function getReleaseTime()
    {
        return $this->time;
    }

    public function getPath()
    {
        return __DIR__;
    }

    public function hasFile($relativePath)
    {
        return file_exists("{$this->getPath()}/{$relativePath}");
    }

    public function getFilePath($relativePath)
    {
        if (!$this->hasFile($relativePath)) {
            throw new FileNotFound(
                "Requested file `{$relativePath}` is not found in downloaded folder."
            );
        }

        return "{$this->getPath()}/{$relativePath}";
    }
}
