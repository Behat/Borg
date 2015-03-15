<?php

namespace spec\Behat\Borg\Integration\Documentation\SphinxDoc;

use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Integration\Documentation\SphinxDoc\Rst;
use Behat\Borg\Release\Downloader\Download;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RstFinderSpec extends ObjectBehavior
{
    function let(Download $download)
    {
        $download->hasFile(Argument::any())->willReturn(false);
    }

    function it_is_a_documentation_source_finder()
    {
        $this->shouldHaveType(SourceFinder::class);
    }

    function it_finds_source_if_the_downloaded_release_has_an_index_rst_in_the_root(Download $download)
    {
        $download->hasFile('index.rst')->willReturn(true);
        $download->path()->willReturn('/root');

        $this->find($download)->shouldBeLike(Rst::atPath('/root'));
    }

    function it_finds_source_if_the_downloaded_release_has_a_doc_folder_with_an_index_rst_in_it(Download $download)
    {
        $download->hasFile('doc/index.rst')->willReturn(true);
        $download->filePath('doc')->willReturn('/root/doc');

        $this->find($download)->shouldBeLike(Rst::atPath('/root/doc'));
    }

    function it_finds_nothing_otherwise(Download $download)
    {
        $this->find($download)->shouldReturn(null);
    }
}
