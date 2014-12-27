<?php

namespace Fake\Package;

use Behat\Borg\Package\Downloader\DownloadedRelease;
use Behat\Borg\Package\Release;
use DateTimeImmutable;

final class FakeDownloadedRelease implements DownloadedRelease
{
    private $release;
    private $releaseTime;

    public function __construct(Release $release)
    {
        $this->release = $release;
        $this->releaseTime = new \DateTimeImmutable();
    }

    /**
     * {@inheritdoc}
     */
    public function getRelease()
    {
        return $this->release;
    }

    /**
     * {@inheritdoc}
     */
    public function getReleaseTime()
    {
        return $this->releaseTime;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return __DIR__;
    }

    /**
     * {@inheritdoc}
     */
    public function hasFile($relativePath)
    {
        return file_exists($this->getPath() . '/' . $relativePath);
    }
}
