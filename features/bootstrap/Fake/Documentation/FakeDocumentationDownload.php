<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Source;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Package;
use Behat\Borg\Release\Release;
use DateTimeImmutable;
use Fake\Release\FakePackageDownload;
use Fake\Release\PackageDownload;

final class FakeDocumentationDownload implements Download, DocumentationDownload, PackageDownload
{
    private $original;
    private $source;

    public function __construct(Release $release, DateTimeImmutable $time, Package $package, Source $source)
    {
        $this->original = new FakePackageDownload($release, $time, $package);
        $this->source = $source;
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
        return $this->original->package();
    }

    public function source()
    {
        return $this->source;
    }
}
