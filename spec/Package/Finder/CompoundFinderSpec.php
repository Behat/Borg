<?php

namespace spec\Behat\Borg\Package\Finder;

use Behat\Borg\Package\Finder\PackageFinder;
use Behat\Borg\Package\Package;
use Behat\Borg\Release\Downloader\Download;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CompoundFinderSpec extends ObjectBehavior
{
    function let(PackageFinder $finder1, PackageFinder $finder2)
    {
        $this->beConstructedWith([$finder1, $finder2]);
    }

    function it_is_a_package_finder()
    {
        $this->shouldHaveType(PackageFinder::class);
    }

    function it_returns_the_package_that_some_of_its_child_finders_finds(
        PackageFinder $finder1,
        PackageFinder $finder2,
        Download $download,
        Package $package
    ) {
        $finder1->findPackage($download)->willReturn(null);
        $finder2->findPackage($download)->willReturn($package);

        $this->findPackage($download)->shouldReturn($package);
    }

    function it_stops_searching_when_first_finder_finds_a_package(
        PackageFinder $finder1,
        PackageFinder $finder2,
        Download $download,
        Package $package
    ) {
        $finder1->findPackage($download)->willReturn($package);
        $finder2->findPackage($download)->shouldNotBeCalled();

        $this->findPackage($download);
    }

    function it_returns_null_if_finders_find_nothing(Download $download)
    {
        $this->findPackage($download)->shouldReturn(null);
    }
}
