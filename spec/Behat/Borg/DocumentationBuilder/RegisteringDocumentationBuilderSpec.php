<?php

namespace spec\Behat\Borg\DocumentationBuilder;

use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use Behat\Borg\DocumentationBuilder\DocumentationBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RegisteringDocumentationBuilderSpec extends ObjectBehavior
{
    function let(DocumentationBuilder $actualBuilder, BuiltDocumentationRepository $repository)
    {
        $this->beConstructedWith($actualBuilder, $repository);
    }

    function it_is_documentation_builder()
    {
        $this->shouldHaveType(DocumentationBuilder::class);
    }
}
