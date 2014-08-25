<?php

namespace spec\Behat\Borg\DocumentationBuilder\BuildSpecification;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\DocumentationBuilder\BuildSpecification\DocumentationBuildSpecification;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateableBuildSpecificationSpec extends ObjectBehavior
{
    function let(BuiltDocumentationRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_build_specification()
    {
        $this->shouldHaveType(DocumentationBuildSpecification::class);
    }

    function it_is_satisfied_by_documentation_that_was_not_built_yet(
        BuiltDocumentationRepository $repository,
        DocumentationId $anId,
        DocumentationSource $source
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new \DateTimeImmutable()
        );
        $repository->hasBuiltDocumentation($anId)->willReturn(false);

        $this->shouldBeSatisfiedByDocumentation($documentation);
    }

    function it_is_satisfied_by_documentation_that_is_updated_version_of_one_built_previously(
        BuiltDocumentationRepository $repository,
        DocumentationId $anId,
        DocumentationSource $source,
        BuiltDocumentation $builtDocumentation
    ) {
        $yesterday = new DateTimeImmutable('yesterday');
        $today = new DateTimeImmutable('now');

        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), $today
        );
        $builtDocumentation->getDocumentationTime()->willReturn($yesterday);

        $repository->hasBuiltDocumentation($anId)->willReturn(true);
        $repository->getBuiltDocumentation($anId)->willReturn($builtDocumentation);

        $this->shouldBeSatisfiedByDocumentation($documentation);
    }

    function it_is_not_satisfied_by_documentation_that_is_exactly_the_same_version_built_previously(
        BuiltDocumentationRepository $repository,
        DocumentationId $anId,
        DocumentationSource $source,
        BuiltDocumentation $builtDocumentation
    ) {
        $today = $today = new DateTimeImmutable('now');
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), $today
        );
        $builtDocumentation->getDocumentationTime()->willReturn($today);

        $repository->hasBuiltDocumentation($anId)->willReturn(true);
        $repository->getBuiltDocumentation($anId)->willReturn($builtDocumentation);

        $this->shouldNotBeSatisfiedByDocumentation($documentation);
    }
}
