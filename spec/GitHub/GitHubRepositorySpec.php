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

    function it_can_only_be_created_using_the_full_github_repository_name()
    {
        $this->shouldThrow()->during('named', ['behat']);
    }

    function it_can_be_created_using_github_repository_name_with_dashes_and_underscores()
    {
        $this->shouldNotThrow()->during('named', ['everzet/basket-by_example']);
    }

    function it_can_be_created_using_github_repository_name_with_periods()
    {
        $this->shouldNotThrow()->during('named', ['everzet/basket.by.example']);
    }

    function its_organisation_is_the_first_segment_of_the_string_it_was_constructed_with()
    {
        $this->getOrganisationName()->shouldReturn('behat');
    }

    function its_name_is_the_second_segment_of_the_string_it_was_constructed_with()
    {
        $this->getName()->shouldReturn('docs');
    }

    function its_string_representation_is_the_string_it_was_constructed_with()
    {
        $this->__toString()->shouldReturn('behat/docs');
    }
}
