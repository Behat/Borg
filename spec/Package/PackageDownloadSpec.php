<?php

namespace spec\Behat\Borg\Package;

use Behat\Borg\Package\Package;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PackageDownloadSpec extends ObjectBehavior
{
    function let(Package $package, Download $download)
    {
        $download->getVersion()->willReturn(Version::string('v2.5.3'));

        $this->beConstructedThrough('packageWasDownloaded', [$package, $download]);
    }

    function it_references_specific_package(Package $package)
    {
        $this->getPackage()->shouldReturn($package);
    }

    function it_references_specific_download(Download $download)
    {
        $this->getDownload()->shouldReturn($download);
    }

    function it_exposes_version_from_download_release()
    {
        $this->getVersion()->shouldBeLike(Version::string('v2.5.3'));
    }

    function it_exposes_release_time(Download $download, \DateTimeImmutable $time)
    {
        $download->getReleaseTime()->willReturn($time);
        $this->getReleaseTime()->shouldReturn($time);
    }
}
