<?php

namespace Fake\Release;

use Behat\Borg\Package\Package;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\Repository;
use Behat\Borg\Release\Version;
use DateTimeImmutable;
use Fake\Documentation\FakeDocumentedDownload;
use Fake\Documentation\FakeSource;

final class FakeRepository implements Repository
{
    private $name;
    private $downloads = [];

    public static function named($name)
    {
        if (2 !== count(explode('/', $name))) {
            throw new \InvalidArgumentException('Package should include organisation and name.');
        }

        $package = new FakeRepository();
        $package->name = $name;

        return $package;
    }

    public function organisationName()
    {
        return explode('/', $this->name)[0];
    }

    public function name()
    {
        return explode('/', $this->name)[1];
    }

    public function __toString()
    {
        return $this->name;
    }

    public function documentPackage(Package $package, Version $version, DateTimeImmutable $time)
    {
        $release = new Release($this, $version);
        $this->downloads[(string)$release] = new FakeDocumentedDownload($release, $time, $package, new FakeSource());
    }

    public function download(Release $release)
    {
        if (isset($this->downloads[(string)$release])) {
            return $this->downloads[(string)$release];
        }

        return new FakeDownload($release, new DateTimeImmutable());
    }

    private function __construct(){}
}
