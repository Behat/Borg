<?php

namespace spec\Behat\Borg\PackageDocumentation;

use Behat\Borg\PackageDocumentation\DocumentationPackage;
use Behat\Borg\Package\Finder\PackageFinder;
use Behat\Borg\Release\Downloader\Download;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationPackageFinderSpec extends ObjectBehavior
{
    function it_is_a_package_finder()
    {
        $this->shouldHaveType(PackageFinder::class);
    }

    function it_finds_a_borg_package_if_download_has_a_borg_json_file(Download $download)
    {
        $download->hasFile('borg.json')->willReturn(true);
        $download->getFilePath('borg.json')->willReturn(__DIR__ . '/borg.json');

        $this->findPackage($download)->shouldBeLike(new DocumentationPackage('behat/behat'));
    }

    function it_finds_nothing_if_download_does_not_have_a_borg_json(Download $download)
    {
        $download->hasFile('borg.json')->willReturn(false);

        $this->findPackage($download)->shouldReturn(null);
    }
}
