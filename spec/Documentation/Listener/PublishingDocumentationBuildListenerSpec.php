<?php

namespace spec\Behat\Borg\Documentation\Listener;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Listener\DocumentationBuildListener;
use Behat\Borg\Documentation\Publisher\DocumentationPublisher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PublishingDocumentationBuildListenerSpec extends ObjectBehavior
{
    function let(DocumentationPublisher $publisher)
    {
        $this->beConstructedWith($publisher);
    }

    function it_is_documentation_build_listener()
    {
        $this->shouldHaveType(DocumentationBuildListener::class);
    }

    function it_publishes_built_documentation(
        DocumentationPublisher $publisher,
        BuiltDocumentation $builtDocumentation
    ) {
        $publisher->publishDocumentation($builtDocumentation)->shouldBeCalled();

        $this->documentationWasBuilt($builtDocumentation);
    }
}
