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
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdatingDocumentationBuilderSpec extends ObjectBehavior
{
    function let(
        DocumentationBuilder $actualBuilder,
        BuiltDocumentationRepository $repository,
        DocumentationBuildSpecification $specification
    ) {
        $this->beConstructedWith($actualBuilder, $repository, $specification);
    }

    function it_is_documentation_builder()
    {
        $this->shouldHaveType(DocumentationBuilder::class);
    }

    function it_builds_documentation_using_actual_builder_if_it_satisfies_specification(
        DocumentationBuilder $actualBuilder,
        DocumentationBuildSpecification $specification,
        DocumentationId $anId,
        DocumentationSource $source
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new DateTimeImmutable()
        );
        $specification->isSatisfiedByDocumentation($documentation)->willReturn(true);

        $actualBuilder->build($documentation)->shouldBeCalled();

        $this->build($documentation);
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
}
