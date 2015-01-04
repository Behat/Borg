<?php

namespace spec\Behat\Borg\Package;

use Behat\Borg\Package\Package;
use Behat\Borg\Release\Downloader\Download;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PackageDownloadSpec extends ObjectBehavior
{
    function let(Package $package, Download $download)
    {
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
}
