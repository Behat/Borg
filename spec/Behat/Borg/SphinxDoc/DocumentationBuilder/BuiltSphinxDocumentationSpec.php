<?php

namespace spec\Behat\Borg\SphinxDoc\DocumentationBuilder;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuiltSphinxDocumentationSpec extends ObjectBehavior
{
    function let(DocumentationId $anId)
    {
        $this->beConstructedWith($anId, __DIR__);
    }

    function it_is_built_documentation()
    {
        $this->shouldHaveType(BuiltDocumentation::class);
    }

    function it_exposes_an_id(DocumentationId $anId)
    {
        $this->getId()->shouldReturn($anId);
    }

    function it_exposes_path_documentation_was_built_into()
    {
        $this->getBuildPath()->shouldReturn(__DIR__);
    }

    function its_index_path_is_the_index_html_in_the_built_path()
    {
        $this->getIndexPath()->shouldReturn(__DIR__ . '/index.html');
    }
}
