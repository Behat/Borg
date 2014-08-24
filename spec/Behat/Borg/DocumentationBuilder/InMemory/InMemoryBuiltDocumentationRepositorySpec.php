<?php

namespace spec\Behat\Borg\DocumentationBuilder\InMemory;

use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InMemoryBuiltDocumentationRepositorySpec extends ObjectBehavior
{
    function it_is_built_documentation_repository()
    {
        $this->shouldHaveType(BuiltDocumentationRepository::class);
    }
}
