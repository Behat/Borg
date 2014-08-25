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

    function it_can_tell_if_documentation_was_built(
        DocumentationId $anId1,
        DocumentationId $anId2,
        BuiltDocumentation $builtDocumentation
    ) {
        $builtDocumentation->getId()->willReturn($anId1);
        $anId1->__toString()->willReturn('doc1');
        $anId2->__toString()->willReturn('doc2');

        $this->addBuiltDocumentation($builtDocumentation);

        $this->shouldHaveBuiltDocumentation($anId1);
        $this->shouldNotHaveBuiltDocumentation($anId2);
    }

    function it_overwrites_documentation_with_same_id(
        DocumentationId $anId,
        BuiltDocumentation $builtDocumentation1,
        BuiltDocumentation $builtDocumentation2
    ) {
        $builtDocumentation1->getId()->willReturn($anId);
        $builtDocumentation2->getId()->willReturn($anId);
        $anId->__toString()->willReturn('doc');

        $this->addBuiltDocumentation($builtDocumentation1);
        $this->addBuiltDocumentation($builtDocumentation2);

        $this->getBuiltDocumentation($anId)->shouldReturn($builtDocumentation2);
    }

    function it_throws_an_exception_on_attempt_to_retrieve_unexisting_documentation(
        DocumentationId $anId
    ) {
        $anId->__toString()->willReturn('doc');

        $this->shouldThrow(InvalidArgumentException::class)->duringGetBuiltDocumentation($anId);
    }
}
