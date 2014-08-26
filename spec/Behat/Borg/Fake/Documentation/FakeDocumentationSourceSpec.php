<?php

namespace spec\Behat\Borg\Fake\Documentation;

use Behat\Borg\Documentation\DocumentationSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FakeDocumentationSourceSpec extends ObjectBehavior
{
    function it_is_a_documentation_source()
    {
        $this->shouldHaveType(DocumentationSource::class);
    }
}
