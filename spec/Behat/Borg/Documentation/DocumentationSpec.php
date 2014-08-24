<?php

namespace spec\Behat\Borg\Documentation;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationSpec extends ObjectBehavior
{
    function let(DocumentationId $anId, DocumentationSource $source)
    {
        $this->beConstructedWith($anId, $source);
    }

    function it_represents_documentation()
    {
        $this->shouldHaveType(Documentation::class);
    }
}
