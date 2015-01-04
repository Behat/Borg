<?php

namespace spec\Behat\Borg\BorgPackage;

use Behat\Borg\BorgPackage\BorgPackage;
use Behat\Borg\Package\Finder\PackageFinder;
use Behat\Borg\Release\Downloader\Download;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BorgPackageFinderSpec extends ObjectBehavior
{
    function it_is_a_package_finder()
    {
        $this->shouldHaveType(PackageFinder::class);
    }

    function it_returns_a_borg_package_with_a_package_name_from_the_download_config(
        Download $download
    ) {
        $download->getPath()->willReturn(__DIR__);
        $download->hasFile('borg.json')->willReturn(true);

        $this->findPackage($download)->shouldBeLike(new BorgPackage('behat/behat'));
    }

    function it_finds_nothing_if_download_does_not_have_borg_config(Download $download)
    {
        $download->hasFile('borg.json')->willReturn(false);

        $this->findPackage($download)->shouldReturn(null);
    }
}
