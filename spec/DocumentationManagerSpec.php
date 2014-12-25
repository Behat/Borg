<?php

namespace spec\Behat\Borg;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Builder\DocumentationBuilder;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\Documentation\Provider\DocumentationProvider;
use Behat\Borg\Documentation\Publisher\DocumentationPublisher;
use Behat\Borg\Documentation\Publisher\Strategy\PublishingStrategy;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationManagerSpec extends ObjectBehavior
{
    function let(
        DocumentationProvider $provider,
        DocumentationBuilder $builder,
        DocumentationPublisher $publisher,
        PublishingStrategy $strategy
    ) {
        $strategy->isSatisfiedByDocumentation(Argument::any())->willReturn(true);

        $this->beConstructedWith($provider, $builder, $publisher, $strategy);
    }

    function it_builds_and_publishes_all_documentation_from_the_provider_using_any_builder(
        DocumentationProvider $provider,
        DocumentationBuilder $builder,
        DocumentationPublisher $publisher,
        DocumentationId $doc1Id,
        DocumentationId $doc2Id,
        DocumentationSource $src,
        BuiltDocumentation $built1,
        BuiltDocumentation $built2
    ) {
        $documentation1 = new Documentation(
            $doc1Id->getWrappedObject(), $src->getWrappedObject(), new \DateTimeImmutable()
        );
        $documentation2 = new Documentation(
            $doc2Id->getWrappedObject(), $src->getWrappedObject(), new \DateTimeImmutable()
        );
        $provider->getAllDocumentation()->willReturn([$documentation1, $documentation2]);

        $builder->build($documentation1)->willReturn($built1);
        $builder->build($documentation2)->willReturn($built2);
        $publisher->publishDocumentation($built1)->shouldBeCalled();
        $publisher->publishDocumentation($built2)->shouldBeCalled();

        $this->publishAllDocumentation();
    }

    function it_skips_documentation_if_it_does_not_satisfy_publishing_strategy(
        DocumentationProvider $provider,
        DocumentationBuilder $builder,
        DocumentationPublisher $publisher,
        DocumentationId $docId,
        DocumentationSource $src,
        PublishingStrategy $strategy
    ) {
        $documentation = new Documentation(
            $docId->getWrappedObject(), $src->getWrappedObject(), new \DateTimeImmutable()
        );
        $provider->getAllDocumentation()->willReturn([$documentation]);

        $strategy->isSatisfiedByDocumentation($documentation)->willReturn(false);

        $builder->build($documentation)->shouldNotBeCalled();
        $publisher->publishDocumentation(Argument::any())->shouldNotBeCalled();

        $this->publishAllDocumentation();
    }

    function it_can_provide_all_currently_built_documentation_from_publisher(
        DocumentationPublisher $publisher,
        DocumentationId $docId,
        BuiltDocumentation $builtDocumentation
    ) {
        $publisher->getPublishedDocumentation($docId)->willReturn($builtDocumentation);

        $this->getPublishedDocumentation($docId)->shouldReturn($builtDocumentation);
    }
}
