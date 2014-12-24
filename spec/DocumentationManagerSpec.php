<?php

namespace spec\Behat\Borg;

use Behat\Borg\Documentation\BuiltDocumentation;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationBuilder;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationProvider;
use Behat\Borg\Documentation\DocumentationPublisher;
use Behat\Borg\Documentation\DocumentationSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationManagerSpec extends ObjectBehavior
{
    function let(
        DocumentationProvider $provider,
        DocumentationBuilder $builder,
        DocumentationPublisher $repository
    ) {
        $this->beConstructedWith($provider, $builder, $repository);
    }

    function it_builds_all_documentation_from_the_provider_using_any_builder(
        DocumentationProvider $provider,
        DocumentationBuilder $builder,
        DocumentationId $doc1Id,
        DocumentationId $doc2Id,
        DocumentationSource $src,
        BuiltDocumentation $built
    ) {
        $documentation1 = new Documentation(
            $doc1Id->getWrappedObject(), $src->getWrappedObject(), new \DateTimeImmutable()
        );
        $documentation2 = new Documentation(
            $doc2Id->getWrappedObject(), $src->getWrappedObject(), new \DateTimeImmutable()
        );
        $provider->getAllDocumentation()->willReturn([$documentation1, $documentation2]);

        $builder->build($documentation1)->shouldBeCalled()->willReturn($built);
        $builder->build($documentation2)->shouldBeCalled()->willReturn($built);

        $this->buildAndPublishDocumentation();
    }

    function it_registers_built_documentation_into_repository(
        DocumentationProvider $provider,
        DocumentationBuilder $builder,
        DocumentationPublisher $repository,
        DocumentationId $docId,
        DocumentationSource $src,
        BuiltDocumentation $built
    ) {
        $documentation = new Documentation(
            $docId->getWrappedObject(), $src->getWrappedObject(), new \DateTimeImmutable()
        );
        $provider->getAllDocumentation()->willReturn([$documentation]);

        $builder->build($documentation)->willReturn($built);
        $repository->publishDocumentation($built)->shouldBeCalled();

        $this->buildAndPublishDocumentation();
    }

    function it_skips_documentation_if_builder_does_not_build_any(
        DocumentationProvider $provider,
        DocumentationBuilder $builder,
        DocumentationPublisher $repository,
        DocumentationId $docId,
        DocumentationSource $src
    ) {
        $documentation = new Documentation(
            $docId->getWrappedObject(), $src->getWrappedObject(), new \DateTimeImmutable()
        );
        $provider->getAllDocumentation()->willReturn([$documentation]);

        $builder->build($documentation)->willReturn(null);
        $repository->publishDocumentation(Argument::any())->shouldNotBeCalled();

        $this->buildAndPublishDocumentation();
    }

    function it_can_provide_all_currently_built_documentation_from_repository(
        DocumentationPublisher $repository,
        DocumentationId $docId,
        BuiltDocumentation $builtDocumentation
    ) {
        $repository->getPublishedDocumentation($docId)->willReturn($builtDocumentation);

        $this->getPublishedDocumentation($docId)->shouldReturn($builtDocumentation);
    }
}
