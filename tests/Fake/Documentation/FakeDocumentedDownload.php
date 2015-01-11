<?php

namespace tests\Behat\Borg\Fake\Documentation;

use Behat\Borg\Documentation\Source;
use Behat\Borg\Package\Package;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Release;
use DateTimeImmutable;
use tests\Behat\Borg\Fake\Package\PackagedDownload;
use tests\Behat\Borg\Fake\Release\FakeDownload;

final class FakeDocumentedDownload implements Download, DocumentedDownload, PackagedDownload
{
    private $original;
    private $package;
    private $source;

    public function __construct(Release $release, DateTimeImmutable $time, Package $package, Source $source)
    {
        $this->original = new FakeDownload($release, $time);
        $this->source = $source;
        $this->package = $package;
    }

    public function getVersion()
    {
        return $this->original->getVersion();
    }

    public function getReleaseTime()
    {
        return $this->original->getReleaseTime();
    }

    public function getPath()
    {
        return $this->original->getPath();
    }

    public function hasFile($relativePath)
    {
        return $this->original->hasFile($relativePath);
    }

    public function getFilePath($relativePath)
    {
        return $this->original->getFilePath($relativePath);
    }

    public function getPackage()
    {
        return $this->package;
    }

    public function getSource()
    {
        return $this->source;
    }
}
