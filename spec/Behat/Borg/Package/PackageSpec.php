<?php

namespace spec\Behat\Borg\Package;

use Behat\Borg\Package\Package;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PackageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromName', ['behat']);
    }

    function it_can_be_constructed_from_name()
    {
        $this->fromName('behat')->shouldHaveType(Package::class);
    }

    function it_exposes_name()
    {
        $this->getName()->shouldReturn('behat');
    }
}
