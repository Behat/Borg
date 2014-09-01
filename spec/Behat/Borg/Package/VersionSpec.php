<?php

namespace spec\Behat\Borg\Package;

use Behat\Borg\Package\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VersionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('string', ['1.0.0']);
    }

    function it_can_be_converted_to_that_string_later()
    {
        $this->__toString()->shouldReturn('1.0.0');
    }
}
