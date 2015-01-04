<?php

namespace spec\Behat\Borg\Package;

use Behat\Borg\Package\Package;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Version;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PackageDownloadSpec extends ObjectBehavior
{
    function let(Package $package, Download $download)
    {
        $download->getVersion()->willReturn(Version::string('v2.5.3'));

        $this->beConstructedThrough('packageWasDownloaded', [$package, $download]);
    }

    function it_holds_a_package(Package $package)
    {
        $this->getPackage()->shouldReturn($package);
    }

    function it_holds_a_download(Download $download)
    {
        $this->getDownload()->shouldReturn($download);
    }

    function its_version_is_the_download_version()
    {
        $this->getVersion()->shouldBeLike(Version::string('v2.5.3'));
    }

    function its_release_time_is_the_download_release_time(Download $download, DateTimeImmutable $time)
    {
        $download->getReleaseTime()->willReturn($time);

        $this->getReleaseTime()->shouldReturn($time);
    }
}
