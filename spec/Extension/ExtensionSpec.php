<?php

namespace spec\Behat\Borg\Extension;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExtensionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('behat', 'symfony2-extension');
    }

    function it_has_an_organisation_name()
    {
        $this->organisationName()->shouldReturn('behat');
    }

    function it_has_a_name()
    {
        $this->name()->shouldReturn('symfony2-extension');
    }

    function it_can_be_converted_to_string()
    {
        $this->__toString()->shouldReturn('behat/symfony2-extension');
    }
}
