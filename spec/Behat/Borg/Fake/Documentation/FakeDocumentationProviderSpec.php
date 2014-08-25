<?php

namespace spec\Behat\Borg\Fake\Documentation;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FakeDocumentationProviderSpec extends ObjectBehavior
{
    function it_has_no_documentation_by_default()
    {
        $this->getAllDocumentation()->shouldReturn([]);
    }

    function it_allows_dynamic_registration_of_documentation(
        DocumentationId $anId,
        DocumentationSource $source
    ) {
        $documentation = new Documentation($anId->getWrappedObject(), $source->getWrappedObject(
        ), new \DateTimeImmutable());

        $this->addDocumentation($documentation);

        $this->getAllDocumentation()->shouldReturn([$documentation]);
    }
}
