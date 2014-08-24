<?php

namespace spec\Behat\Borg\Documentation\InMemory;

use Behat\Borg\Documentation\DocumentationProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InMemoryDocumentationProviderSpec extends ObjectBehavior
{
    function it_is_documentation_provider()
    {
        $this->shouldHaveType(DocumentationProvider::class);
    }
}
