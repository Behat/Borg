<?php

namespace spec\Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use Behat\Borg\DocumentationBuilder\DocumentationBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RegisteringDocumentationBuilderSpec extends ObjectBehavior
{
    function let(DocumentationBuilder $actualBuilder, BuiltDocumentationRepository $repository)
    {
        $this->beConstructedWith($actualBuilder, $repository);
    }

    function it_is_documentation_builder()
    {
        $this->shouldHaveType(DocumentationBuilder::class);
    }

    function it_builds_documentation_using_the_builder_it_was_constructed_with(
        DocumentationId $anId,
        DocumentationSource $source,
        DocumentationBuilder $actualBuilder
    ) {
        $documentation = new Documentation($anId->getWrappedObject(), $source->getWrappedObject());

        $actualBuilder->build($documentation)->shouldBeCalled();

        $this->build($documentation);
    }
}
