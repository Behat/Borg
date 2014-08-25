<?php

namespace spec\Behat\Borg\SphinxDoc\Documentation;

use Behat\Borg\Documentation\DocumentationSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RstDocumentationSourceSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('atPath', [__DIR__]);
    }

    function it_is_documentation_source()
    {
        $this->shouldHaveType(DocumentationSource::class);
    }

    function it_exposes_path()
    {
        $this->getPath()->shouldReturn(__DIR__);
    }
}
