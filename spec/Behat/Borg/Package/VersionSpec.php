<?php

namespace spec\Behat\Borg\Package;

use Behat\Borg\Package\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VersionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromString', ['1.0.0']);
    }

    function it_can_be_constructed_from_string()
    {
        $this->fromString('1.0.0')->shouldHaveType(Version::class);
    }

    function it_can_be_converted_to_string()
    {
        $this->__toString()->shouldReturn('1.0.0');
    }
}
