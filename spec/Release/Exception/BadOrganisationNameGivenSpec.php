<?php

namespace spec\Behat\Borg\Release\Exception;

use Behat\Borg\Release\Exception\RepositoryException;
use LogicException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BadOrganisationNameGivenSpec extends ObjectBehavior
{
    function it_is_a_repository_exception()
    {
        $this->shouldHaveType(RepositoryException::class);
    }

    function it_is_also_a_logic_exception()
    {
        $this->shouldHaveType(LogicException::class);
    }
}
