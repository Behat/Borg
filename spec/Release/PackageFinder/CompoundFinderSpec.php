<?php

namespace spec\Behat\Borg\Release\PackageFinder;

use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Package;
use Behat\Borg\Release\PackageFinder\PackageFinder;
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
        $finder1->find($download)->willReturn(null);
        $finder2->find($download)->willReturn($package);

        $this->find($download)->shouldReturn($package);
    }

    function it_stops_searching_when_first_finder_finds_a_package(
        PackageFinder $finder1,
        PackageFinder $finder2,
        Download $download,
        Package $package
    ) {
        $finder1->find($download)->willReturn($package);
        $finder2->find($download)->shouldNotBeCalled();

        $this->find($download);
    }

    function it_returns_null_if_all_finders_find_nothing(Download $download)
    {
        $this->find($download)->shouldReturn(null);
    }
}
