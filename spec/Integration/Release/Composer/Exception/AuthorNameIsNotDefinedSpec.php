<?php

namespace spec\Behat\Borg\Integration\Release\Composer\Exception;

use Behat\Borg\Release\Exception\ReleaseException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthorNameIsNotDefinedSpec extends ObjectBehavior
{
    function it_is_InvalidArgumentException()
    {
        $this->shouldHaveType(InvalidArgumentException::class);
    }

    function it_is_also_a_ReleaseException()
    {
        $this->shouldHaveType(ReleaseException::class);
    }
}
