<?php

namespace spec\Behat\Borg\Integration\Package\ComposerPackage;

use Behat\Borg\Package\Package;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ComposerPackageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('behat/docs');
    }

    function it_is_a_package()
    {
        $this->shouldHaveType(Package::class);
    }

    function it_can_not_be_constructed_with_a_name_that_has_less_than_2_segments_in_it()
    {
        $this->shouldThrow()->during('__construct', ['behat']);
    }

    function it_can_not_be_constructed_with_a_name_that_has_more_than_2_segments_in_it()
    {
        $this->shouldThrow()->during('__construct', ['behat/docs/v2']);
    }

    function its_organisation_name_is_a_first_segment_of_the_constructor_argument()
    {
        $this->organisationName()->shouldReturn('behat');
    }

    function it_lowercases_provided_organisation_and_package_name()
    {
        $this->beConstructedWith('Behat/Docs');

        $this->organisationName()->shouldReturn('behat');
        $this->name()->shouldReturn('docs');
    }

    function its_name_is_a_second_segment_of_the_constructor_argument()
    {
        $this->name()->shouldReturn('docs');
    }

    function its_string_representation_is_the_name_of_the_package()
    {
        $this->__toString()->shouldReturn('behat/docs');
    }
}
