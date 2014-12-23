<?php

namespace spec\Behat\Borg\GitHub;

use Behat\Borg\Package\Package;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GitHubPackageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('named', ['behat/docs']);
    }

    function it_is_a_package()
    {
        $this->shouldHaveType(Package::class);
    }

    function it_can_only_be_created_using_proper_github_package_name()
    {
        $this->shouldThrow()->during('named', ['behat']);
    }

    function it_belongs_to_some_organisation()
    {
        $this->getOrganisation()->shouldReturn('behat');
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('docs');
    }

    function it_can_be_converted_to_string()
    {
        $this->__toString()->shouldReturn('behat/docs');
    }
}
