<?php

namespace spec\Behat\Borg\Package;

use Behat\Borg\Package\Package;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimplePackageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Behat', 'docs');
    }

    function it_is_a_package()
    {
        $this->shouldHaveType(Package::class);
    }

    function it_does_not_allow_creation_of_a_package_with_wrong_organisation_name()
    {
        $this->shouldThrow()->during('__construct', ['B@hat', 'docs']);
    }

    function it_does_not_allow_creation_of_a_package_with_wrong_name()
    {
        $this->shouldThrow()->during('__construct', ['Behat', 'doc$']);
    }

    function it_belongs_to_some_organisation()
    {
        $this->getOrganisation()->shouldReturn('Behat');
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('docs');
    }

    function it_could_be_converted_to_string()
    {
        $this->__toString()->shouldReturn('Behat/docs');
    }
}
