<?php

namespace spec\Behat\Borg\Package\Documentation;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Provider\DocumentationProvider;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Downloader\DownloadedRelease;
use Behat\Borg\Package\Downloader\ReleaseDownloader;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Behat\Borg\SphinxDoc\RstDocumentationSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReleaseDocumentationProviderSpec extends ObjectBehavior
{
    function let(ReleaseDownloader $downloader, DownloadedRelease $downloadedRelease)
    {
        $downloadedRelease->hasFile(Argument::any())->willReturn(false);

        $this->beConstructedWith($downloader);
    }

    function it_is_a_documentation_provider()
    {
        $this->shouldHaveType(DocumentationProvider::class);
    }

    function it_can_provide_sphinx_documentation_from_doc_folder_in_downloaded_release(
        Package $package,
        ReleaseDownloader $downloader,
        DownloadedRelease $downloadedRelease
    ) {
        $release = new Release($package->getWrappedObject(), Version::string('v2.5'));
        $releaseTime = new \DateTimeImmutable();
        $anId = new ReleaseDocumentationId($release);
        $downloader->downloadRelease($release)->willReturn($downloadedRelease);

        $downloadedRelease->getRelease()->willReturn($release);
        $downloadedRelease->getReleaseTime()->willReturn($releaseTime);
        $downloadedRelease->hasFile('doc/index.rst')->willReturn(true);
        $downloadedRelease->getPath()->willReturn('/full/path');

        $this->findDocumentationById($anId)->shouldBeLike(
            new Documentation($anId, RstDocumentationSource::atPath('/full/path/doc'), $releaseTime)
        );
    }

    function it_can_provide_sphinx_documentation_from_root_folder_in_downloaded_release(
        Package $package,
        ReleaseDownloader $downloader,
        DownloadedRelease $downloadedRelease
    ) {
        $release = new Release($package->getWrappedObject(), Version::string('v2.5'));
        $releaseTime = new \DateTimeImmutable();
        $anId = new ReleaseDocumentationId($release);
        $downloader->downloadRelease($release)->willReturn($downloadedRelease);

        $downloadedRelease->getRelease()->willReturn($release);
        $downloadedRelease->getReleaseTime()->willReturn($releaseTime);
        $downloadedRelease->hasFile('index.rst')->willReturn(true);
        $downloadedRelease->getPath()->willReturn('/full/path');

        $this->findDocumentationById($anId)->shouldBeLike(
            new Documentation($anId, RstDocumentationSource::atPath('/full/path'), $releaseTime)
        );
    }

    function it_returns_null_if_documentation_is_not_presented_in_root_or_doc_folder(
        Package $package,
        ReleaseDownloader $downloader,
        DownloadedRelease $downloadedRelease
    ) {
        $release = new Release($package->getWrappedObject(), Version::string('v2.5'));
        $releaseTime = new \DateTimeImmutable();
        $anId = new ReleaseDocumentationId($release);
        $downloader->downloadRelease($release)->willReturn($downloadedRelease);

        $downloadedRelease->getRelease()->willReturn($release);
        $downloadedRelease->getReleaseTime()->willReturn($releaseTime);

        $this->findDocumentationById($anId)->shouldReturn(null);
    }

    function it_throws_an_exception_if_asked_to_provide_documentation_for_non_released_docs(
        DocumentationId $anId
    ) {
        $this->shouldThrow()->duringFindDocumentationById($anId->getWrappedObject());
    }

    function it_can_provide_available_documentation_for_all_downloaded_releases(
        ReleaseDownloader $downloader,
        Package $package1,
        Package $package2,
        DownloadedRelease $downloadedRelease1,
        DownloadedRelease $downloadedRelease2
    ) {
        $release1 = new Release($package1->getWrappedObject(), Version::string('v2.5'));
        $releaseTime = new \DateTimeImmutable();
        $anId1 = new ReleaseDocumentationId($release1);
        $release2 = new Release($package2->getWrappedObject(), Version::string('v3.0'));
        $anId2 = new ReleaseDocumentationId($release2);
        $downloader->downloadAllReleases()->willReturn([$downloadedRelease1, $downloadedRelease2]);

        $downloadedRelease1->getRelease()->willReturn($release1);
        $downloadedRelease1->getReleaseTime()->willReturn($releaseTime);
        $downloadedRelease1->hasFile('index.rst')->willReturn(true);
        $downloadedRelease1->hasFile('doc/index.rst')->willReturn(false);
        $downloadedRelease1->getPath()->willReturn('/full/path');

        $downloadedRelease2->getRelease()->willReturn($release2);
        $downloadedRelease2->getReleaseTime()->willReturn($releaseTime);
        $downloadedRelease2->hasFile('index.rst')->willReturn(false);
        $downloadedRelease2->hasFile('doc/index.rst')->willReturn(true);
        $downloadedRelease2->getPath()->willReturn('/full/path');

        $this->getAllDocumentation()->shouldBeLike([
            new Documentation($anId1, RstDocumentationSource::atPath('/full/path'), $releaseTime),
            new Documentation($anId2, RstDocumentationSource::atPath('/full/path/doc'), $releaseTime)
        ]);
    }
}
