<?php

namespace spec\Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use Behat\Borg\DocumentationBuilder\DocumentationBuilder;
use InvalidArgumentException;
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
        DocumentationBuilder $actualBuilder,
        BuiltDocumentation $builtDocumentation
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new \DateTimeImmutable()
        );

        $actualBuilder->build($documentation)->willReturn($builtDocumentation);

        $this->build($documentation)->shouldReturn($builtDocumentation);
    }

    function it_throws_an_exception_if_original_builder_does_not_produce_result(
        DocumentationId $anId,
        DocumentationSource $source,
        DocumentationBuilder $actualBuilder
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new \DateTimeImmutable()
        );

        $actualBuilder->build($documentation)->willReturn(null);

        $this->shouldThrow(InvalidArgumentException::class)->duringBuild($documentation);
    }

    function it_adds_built_documentation_into_the_repository(
        DocumentationId $anId,
        DocumentationSource $source,
        DocumentationBuilder $actualBuilder,
        BuiltDocumentation $builtDocumentation,
        BuiltDocumentationRepository $repository
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new \DateTimeImmutable()
        );
        $actualBuilder->build($documentation)->willReturn($builtDocumentation);

        $repository->addBuiltDocumentation($builtDocumentation)->shouldBeCalled();

        $this->build($documentation);
    }
}
