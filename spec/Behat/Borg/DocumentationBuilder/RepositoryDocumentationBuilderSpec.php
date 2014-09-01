<?php

namespace spec\Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\DocumentationBuilder\BuildSpecification\DocumentationBuildSpecification;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
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
        DocumentationGenerator $generator
    ) {
        $this->beConstructedWith($specification, $generator);
    }

    function it_is_a_documentation_builder()
    {
        $this->shouldHaveType(DocumentationBuilder::class);
    }

    function it_does_not_generate_documentation_if_one_does_not_satisfy_specification(
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

        $this->build($documentation)->shouldReturn(null);
    }

    function it_generates_documentation_using_generator_if_it_does_satisfy_specification(
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
        $generator->generate($documentation)->willReturn($builtDocumentation);

        $this->build($documentation)->shouldReturn($builtDocumentation);
    }

    function it_throws_an_exception_if_generator_does_not_produce_any_result(
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
}
