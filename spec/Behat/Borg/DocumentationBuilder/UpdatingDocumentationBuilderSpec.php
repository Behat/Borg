<?php

namespace spec\Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use Behat\Borg\DocumentationBuilder\DocumentationBuilder;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdatingDocumentationBuilderSpec extends ObjectBehavior
{
    function let(DocumentationBuilder $actualBuilder, BuiltDocumentationRepository $repository)
    {
        $this->beConstructedWith($actualBuilder, $repository);
    }

    function it_is_documentation_builder()
    {
        $this->shouldHaveType(DocumentationBuilder::class);
    }

    function it_builds_documentation_using_actual_builder_if_repository_does_not_have_it_yet(
        DocumentationBuilder $actualBuilder,
        BuiltDocumentationRepository $repository,
        DocumentationId $anId,
        DocumentationSource $source
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new \DateTimeImmutable()
        );
        $repository->hasBuiltDocumentation($anId)->willReturn(false);

        $actualBuilder->build($documentation)->shouldBeCalled();

        $this->build($documentation);
    }

    function it_builds_documentation_using_actual_builder_if_repository_has_outdated_version(
        DocumentationBuilder $actualBuilder,
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

        $actualBuilder->build($documentation)->shouldBeCalled();

        $this->build($documentation);
    }

    function it_does_not_build_documentation_if_repository_already_has_updated_version(
        DocumentationBuilder $actualBuilder,
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

        $actualBuilder->build($documentation)->shouldNotBeCalled();

        $this->build($documentation);
    }
}
