<?php

namespace spec\Behat\Borg\ComposerPackage;

use Behat\Borg\ComposerPackage\ComposerPackage;
use Behat\Borg\Package\Finder\PackageFinder;
use Behat\Borg\Release\Downloader\Download;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ComposerPackageFinderSpec extends ObjectBehavior
{
    function it_is_a_package_finder()
    {
        $this->shouldHaveType(PackageFinder::class);
    }

    function it_returns_a_composer_package_with_a_package_name_from_the_download_json(Download $download)
    {
        $download->getPath()->willReturn(__DIR__);
        $download->hasFile('composer.json')->willReturn(true);

        $this->findPackage($download)->shouldBeLike(new ComposerPackage('behat/behat'));
    }

    function it_finds_nothing_if_download_does_not_have_composer_json(Download $download)
    {
        $download->hasFile('composer.json')->willReturn(false);

        $this->findPackage($download)->shouldReturn(null);
    }
}
