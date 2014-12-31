<?php

namespace spec\Behat\Borg\Documentation\Page;

use Behat\Borg\Documentation\DocumentationId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PageIdSpec extends ObjectBehavior
{
    function let(DocumentationId $anId)
    {
        $this->beConstructedWith($anId, '/doc/path');
    }

    function it_holds_the_documentation_id(DocumentationId $anId)
    {
        $this->getDocumentationId()->shouldReturn($anId);
    }

    function it_holds_a_page_path()
    {
        $this->getPath()->shouldReturn('/doc/path');
    }
}
