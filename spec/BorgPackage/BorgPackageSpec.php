<?php

namespace spec\Behat\Borg\BorgPackage;

use Behat\Borg\Package\Package;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BorgPackageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('behat/docs');
    }

    function it_is_a_package()
    {
        $this->shouldHaveType(Package::class);
    }

    function it_can_not_be_constructed_with_a_name_that_has_less_than_2_segments()
    {
        $this->shouldThrow()->during('__construct', ['behat']);
    }

    function it_can_not_be_constructed_with_a_name_that_has_more_than_2_segments()
    {
        $this->shouldThrow()->during('__construct', ['behat/docs/v2']);
    }

    function its_organisation_name_is_a_first_segment_of_construction_parameter()
    {
        $this->getOrganisation()->shouldReturn('behat');
    }

    function its_name_is_a_second_segment_of_construction_parameter()
    {
        $this->getName()->shouldReturn('docs');
    }

    function it_can_be_converted_to_string()
    {
        $this->__toString()->shouldReturn('behat/docs');
    }
}
