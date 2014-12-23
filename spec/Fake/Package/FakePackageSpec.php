<?php

namespace spec\Behat\Borg\Fake\Package;

use Behat\Borg\Package\Package;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FakePackageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('named', ['behat']);
    }

    function it_is_a_package()
    {
        $this->shouldHaveType(Package::class);
    }

    function it_can_be_converted_to_string()
    {
        $this->__toString()->shouldReturn('behat');
    }
}
