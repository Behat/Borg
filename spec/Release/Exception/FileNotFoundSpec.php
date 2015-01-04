<?php

namespace spec\Behat\Borg\Release\Exception;

use Behat\Borg\Release\Exception\ReleaseException;
use LogicException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileNotFoundSpec extends ObjectBehavior
{
    function it_is_a_release_exception()
    {
        $this->shouldHaveType(ReleaseException::class);
    }

    function it_also_is_a_logic_exception()
    {
        $this->shouldHaveType(LogicException::class);
    }
}
