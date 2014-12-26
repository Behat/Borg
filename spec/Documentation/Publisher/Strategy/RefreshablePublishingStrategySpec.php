<?php

namespace spec\Behat\Borg\Documentation\Publisher\Strategy;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\Documentation\Publisher\DocumentationPublisher;
use Behat\Borg\Documentation\Publisher\Strategy\PublishingStrategy;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RefreshablePublishingStrategySpec extends ObjectBehavior
{
    function let(DocumentationPublisher $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_a_build_strategy()
    {
        $this->shouldHaveType(PublishingStrategy::class);
    }

    function it_is_satisfied_by_documentation_that_was_not_yet_built(
        DocumentationPublisher $repository,
        DocumentationId $anId,
        DocumentationSource $source
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new \DateTimeImmutable()
        );
        $repository->hasPublishedDocumentation($anId)->willReturn(false);

        $this->shouldBeSatisfiedByDocumentation($documentation);
    }

    function it_is_satisfied_by_documentation_that_is_updated_version_of_the_one_built_previously(
        DocumentationPublisher $repository,
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

        $repository->hasPublishedDocumentation($anId)->willReturn(true);
        $repository->getPublishedDocumentation($anId)->willReturn($builtDocumentation);

        $this->shouldBeSatisfiedByDocumentation($documentation);
    }

    function it_is_not_satisfied_by_documentation_that_is_exactly_the_same_one_built_previously(
        DocumentationPublisher $repository,
        DocumentationId $anId,
        DocumentationSource $source,
        BuiltDocumentation $builtDocumentation
    ) {
        $today = $today = new DateTimeImmutable('now');
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), $today
        );
        $builtDocumentation->getDocumentationTime()->willReturn($today);

        $repository->hasPublishedDocumentation($anId)->willReturn(true);
        $repository->getPublishedDocumentation($anId)->willReturn($builtDocumentation);

        $this->shouldNotBeSatisfiedByDocumentation($documentation);
    }
}