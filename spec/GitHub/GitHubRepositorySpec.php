<?php

namespace spec\Behat\Borg\GitHub;

use Behat\Borg\Release\Repository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GitHubRepositorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('named', ['behat/docs']);
    }

    function it_is_a_repository()
    {
        $this->shouldHaveType(Repository::class);
    }

    function it_can_only_be_created_using_full_github_repository_name()
    {
        $this->shouldThrow()->during('named', ['behat']);
    }

    function it_can_be_created_using_github_repository_name_with_dashes_and_underscores()
    {
        $this->shouldNotThrow()->during('named', ['everzet/basket-by-example']);
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
