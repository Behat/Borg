<?php

namespace spec\Behat\Borg\Package;

use Behat\Borg\Package\Package;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PackageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('named', ['behat']);
    }

    function it_can_be_converted_to_string()
    {
        $this->__toString()->shouldReturn('behat');
    }
}
