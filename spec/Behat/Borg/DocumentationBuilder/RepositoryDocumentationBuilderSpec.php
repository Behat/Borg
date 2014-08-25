<?php

namespace spec\Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\DocumentationBuilder\BuildSpecification\DocumentationBuildSpecification;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use Behat\Borg\DocumentationBuilder\DocumentationBuilder;
use Behat\Borg\DocumentationBuilder\Generator\DocumentationGenerator;
use DateTimeImmutable;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RepositoryDocumentationBuilderSpec extends ObjectBehavior
{
    function let(
        DocumentationBuildSpecification $specification,
        DocumentationGenerator $generator,
        BuiltDocumentationRepository $repository
    ) {
        $this->beConstructedWith($specification, $generator, $repository);
    }

    function it_is_documentation_builder()
    {
        $this->shouldHaveType(DocumentationBuilder::class);
    }

    function it_does_not_generate_documentation_if_it_does_not_satisfy_specification(
        DocumentationGenerator $generator,
        DocumentationBuildSpecification $specification,
        DocumentationId $anId,
        DocumentationSource $source
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new DateTimeImmutable()
        );
        $specification->isSatisfiedByDocumentation($documentation)->willReturn(false);

        $generator->generate($documentation)->shouldNotBeCalled();

        $this->build($documentation);
    }

    function it_generates_documentation_using_generator_if_it_satisfies_specification(
        DocumentationGenerator $generator,
        DocumentationBuildSpecification $specification,
        DocumentationId $anId,
        DocumentationSource $source,
        BuiltDocumentation $builtDocumentation
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new DateTimeImmutable()
        );
        $specification->isSatisfiedByDocumentation($documentation)->willReturn(true);
        $generator->generate($documentation)->willReturn($builtDocumentation)->shouldBeCalled();

        $this->build($documentation);
    }

    function it_throws_an_exception_if_generator_does_not_produce_result(
        DocumentationGenerator $generator,
        DocumentationBuildSpecification $specification,
        DocumentationId $anId,
        DocumentationSource $source
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new DateTimeImmutable()
        );
        $specification->isSatisfiedByDocumentation($documentation)->willReturn(true);
        $generator->generate($documentation)->willReturn(null);

        $this->shouldThrow(InvalidArgumentException::class)->duringBuild($documentation);
    }

    function it_adds_built_documentation_into_the_repository(
        DocumentationGenerator $generator,
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
        $generator->generate($documentation)->willReturn($builtDocumentation);

        $repository->addBuiltDocumentation($builtDocumentation)->shouldBeCalled();

        $this->build($documentation);
    }
}
