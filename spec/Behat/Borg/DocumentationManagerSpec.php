<?php

namespace spec\Behat\Borg;

use Behat\Borg\Documentation\DocumentationProvider;
use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationManagerSpec extends ObjectBehavior
{
    function let(DocumentationProvider $provider, BuiltDocumentationRepository $repository)
    {
        $this->beConstructedWith($provider, $repository);
    }

    function it_can_build_the_documentation()
    {
        $this->buildDocumentation();
    }
}
