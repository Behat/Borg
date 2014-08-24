<?php

namespace spec\Behat\Borg;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationProvider;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\DocumentationBuilder\DocumentationBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationManagerSpec extends ObjectBehavior
{
    function let(DocumentationProvider $provider, DocumentationBuilder $builder)
    {
        $this->beConstructedWith($provider, $builder);
    }

    function it_builds_documentation_from_provider_using_the_builder(
        DocumentationProvider $provider,
        DocumentationBuilder $builder,
        DocumentationId $doc1Id,
        DocumentationId $doc2Id,
        DocumentationSource $src
    ) {
        $documentation1 = new Documentation($doc1Id->getWrappedObject(), $src->getWrappedObject());
        $documentation2 = new Documentation($doc2Id->getWrappedObject(), $src->getWrappedObject());
        $provider->getAllDocumentation()->willReturn([$documentation1, $documentation2]);

        $builder->build($documentation1)->shouldBeCalled();
        $builder->build($documentation2)->shouldBeCalled();

        $this->buildDocumentation();
    }
}
