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
        $download->version()->willReturn(Version::string('v2.5.3'));

        $this->beConstructedWith($package, $download);
    }

    function it_holds_a_package(Package $package)
    {
        $this->package()->shouldReturn($package);
    }

    function it_holds_a_download(Download $download)
    {
        $this->download()->shouldReturn($download);
    }
}
