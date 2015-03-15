<?php

namespace Fake\Release;

use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Package;
use Behat\Borg\Release\Release;
use DateTimeImmutable;

final class FakePackageDownload implements Download, PackageDownload
{
    private $original;
    private $package;

    public function __construct(Release $release, DateTimeImmutable $time, Package $package)
    {
        $this->original = new FakeDownload($release, $time);
        $this->package = $package;
    }

    public function version()
    {
        return $this->original->version();
    }

    public function releasedAt()
    {
        return $this->original->releasedAt();
    }

    public function path()
    {
        return $this->original->path();
    }

    public function hasFile($relativePath)
    {
        return $this->original->hasFile($relativePath);
    }

    public function filePath($relativePath)
    {
        return $this->original->filePath($relativePath);
    }

    public function package()
    {
        return $this->package;
    }
}
