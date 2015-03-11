<?php

namespace spec\Behat\Borg\Documentation;

use Behat\Borg\Documentation\DocumentationId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationIdSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('behat/docs', 'v3.0');
    }

    function it_is_a_documentation_id()
    {
        $this->shouldHaveType(DocumentationId::class);
    }

    function its_project_name_is_the_first_argument_it_was_constructed_with()
    {
        $this->projectName()->shouldReturn('behat/docs');
    }

    function its_version_string_is_the_second_argument_it_was_constructed_with()
    {
        $this->versionString()->shouldReturn('v3.0');
    }

    function its_string_representation_is_the_project_name_and_version_string_separated_by_slash()
    {
        $this->__toString()->shouldReturn('behat/docs/v3.0');
    }
}
