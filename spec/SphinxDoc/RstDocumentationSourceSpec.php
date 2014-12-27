<?php

namespace spec\Behat\Borg\SphinxDoc;

use Behat\Borg\Documentation\DocumentationSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RstDocumentationSourceSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('atPath', [__DIR__]);
    }

    function it_is_a_documentation_source()
    {
        $this->shouldHaveType(DocumentationSource::class);
    }

    function it_has_path_to_all_its_RST_documents()
    {
        $this->getPath()->shouldReturn(__DIR__);
    }
}
