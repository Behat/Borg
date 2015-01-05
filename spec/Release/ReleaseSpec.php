<?php

namespace spec\Behat\Borg\Release;

use Behat\Borg\Release\Repository;
use Behat\Borg\Release\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReleaseSpec extends ObjectBehavior
{
    function let(Repository $repository)
    {
        $repository->__toString()->willReturn('my_package');
    }

    function it_is_a_combination_of_repository_and_a_specific_version(Repository $repository)
    {
        $version = Version::string('1.0.0');
        $this->beConstructedWith($repository, $version);

        $this->getRepository()->shouldReturn($repository);
        $this->getVersion()->shouldReturn($version);
    }

    function its_string_representation_is_a_repository_and_version_separated_by_slash(Repository $repository)
    {
        $this->beConstructedWith($repository, Version::string('1.0.0'));

        $this->__toString()->shouldReturn('my_package/1.0.0');
    }
}
