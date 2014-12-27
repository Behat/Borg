<?php

namespace spec\Behat\Borg\SphinxDoc;

use Behat\Borg\Documentation\Finder\DocumentationSourceFinder;
use Behat\Borg\Package\Downloader\DownloadedRelease;
use Behat\Borg\SphinxDoc\RstDocumentationSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RstDocumentationSourceFinderSpec extends ObjectBehavior
{
    function let(DownloadedRelease $release)
    {
        $release->hasFile(Argument::any())->willReturn(false);
    }

    function it_is_documentation_finder()
    {
        $this->shouldHaveType(DocumentationSourceFinder::class);
    }

    function it_finds_source_if_downloaded_release_has_index_rst_in_root_folder(
        DownloadedRelease $release
    ) {
        $release->hasFile('index.rst')->willReturn(true);
        $release->getPath()->willReturn('/root');

        $this->findDocumentationSource($release)->shouldBeLike(
            RstDocumentationSource::atPath('/root')
        );
    }

    function it_finds_source_if_downloaded_release_has_doc_folder_with_index_rst_in_it(
        DownloadedRelease $release
    ) {
        $release->hasFile('doc/index.rst')->willReturn(true);
        $release->getPath()->willReturn('/root');

        $this->findDocumentationSource($release)->shouldBeLike(
            RstDocumentationSource::atPath('/root/doc')
        );
    }

    function it_returns_null_otherwise(DownloadedRelease $release)
    {
        $this->findDocumentationSource($release)->shouldReturn(null);
    }
}
