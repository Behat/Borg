<?php

namespace spec\Behat\Borg\Release\Exception;

use Behat\Borg\Release\Exception\ReleaseException;
use LogicException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BadRepositoryNameGivenSpec extends ObjectBehavior
{
    function it_is_a_repository_exception()
    {
        $this->shouldHaveType(ReleaseException::class);
    }

    function it_is_also_a_logic_exception()
    {
        $this->shouldHaveType(LogicException::class);
    }
}
