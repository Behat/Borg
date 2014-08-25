<?php

namespace spec\Behat\Borg\DocumentationBuilder\InMemory;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InMemoryBuiltDocumentationRepositorySpec extends ObjectBehavior
{
    function it_is_built_documentation_repository()
    {
        $this->shouldHaveType(BuiltDocumentationRepository::class);
    }

    function it_can_find_built_documentation_by_an_id(
        DocumentationId $anId,
        BuiltDocumentation $builtDocumentation
    ) {
        $builtDocumentation->getId()->willReturn($anId);
        $anId->__toString()->willReturn('doc');

        $this->addBuiltDocumentation($builtDocumentation);

        $this->getBuiltDocumentation($anId)->shouldReturn($builtDocumentation);
    }

    function it_throws_an_exception_on_attempt_to_retrieve_unexisting_documentation(
        DocumentationId $anId
    ) {
        $anId->__toString()->willReturn('doc');

        $this->shouldThrow(InvalidArgumentException::class)->duringGetBuiltDocumentation($anId);
    }
}
