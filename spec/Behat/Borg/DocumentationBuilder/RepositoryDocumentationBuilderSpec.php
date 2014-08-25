<?php

namespace spec\Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\DocumentationBuilder\BuildSpecification\DocumentationBuildSpecification;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use Behat\Borg\DocumentationBuilder\DocumentationBuilder;
use DateTimeImmutable;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RepositoryDocumentationBuilderSpec extends ObjectBehavior
{
    function let(
        DocumentationBuildSpecification $specification,
        DocumentationBuilder $actualBuilder,
        BuiltDocumentationRepository $repository
    ) {
        $this->beConstructedWith($specification, $actualBuilder, $repository);
    }

    function it_is_documentation_builder()
    {
        $this->shouldHaveType(DocumentationBuilder::class);
    }

    function it_does_not_build_documentation_if_it_does_not_satisfy_specification(
        DocumentationBuilder $actualBuilder,
        DocumentationBuildSpecification $specification,
        DocumentationId $anId,
        DocumentationSource $source
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new DateTimeImmutable()
        );
        $specification->isSatisfiedByDocumentation($documentation)->willReturn(false);

        $actualBuilder->build($documentation)->shouldNotBeCalled();

        $this->build($documentation);
    }

    function it_builds_documentation_using_actual_builder_if_it_satisfies_specification(
        DocumentationBuilder $actualBuilder,
        DocumentationBuildSpecification $specification,
        DocumentationId $anId,
        DocumentationSource $source,
        BuiltDocumentation $builtDocumentation
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new DateTimeImmutable()
        );
        $specification->isSatisfiedByDocumentation($documentation)->willReturn(true);
        $actualBuilder->build($documentation)->willReturn($builtDocumentation);

        $this->build($documentation)->shouldReturn($builtDocumentation);
    }

    function it_throws_an_exception_if_original_builder_does_not_produce_result(
        DocumentationBuilder $actualBuilder,
        DocumentationBuildSpecification $specification,
        DocumentationId $anId,
        DocumentationSource $source
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new DateTimeImmutable()
        );
        $specification->isSatisfiedByDocumentation($documentation)->willReturn(true);
        $actualBuilder->build($documentation)->willReturn(null);

        $this->shouldThrow(InvalidArgumentException::class)->duringBuild($documentation);
    }

    function it_adds_built_documentation_into_the_repository(
        DocumentationBuilder $actualBuilder,
        DocumentationBuildSpecification $specification,
        DocumentationId $anId,
        DocumentationSource $source,
        BuiltDocumentation $builtDocumentation,
        BuiltDocumentationRepository $repository
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new DateTimeImmutable()
        );
        $specification->isSatisfiedByDocumentation($documentation)->willReturn(true);
        $actualBuilder->build($documentation)->willReturn($builtDocumentation);

        $repository->addBuiltDocumentation($builtDocumentation)->shouldBeCalled();

        $this->build($documentation);
    }
}
