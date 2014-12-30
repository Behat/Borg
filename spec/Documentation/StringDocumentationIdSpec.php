<?php

namespace spec\Behat\Borg\Documentation;

use Behat\Borg\Documentation\DocumentationId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StringDocumentationIdSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('behat/docs', 'v3.0');
    }

    function it_is_documentation_id()
    {
        $this->shouldHaveType(DocumentationId::class);
    }

    function it_has_a_project_name()
    {
        $this->getProjectName()->shouldReturn('behat/docs');
    }

    function it_has_a_version_string()
    {
        $this->getVersionString()->shouldReturn('v3.0');
    }

    function it_can_be_converted_to_string()
    {
        $this->__toString()->shouldReturn('behat/docs/v3.0');
    }
}
