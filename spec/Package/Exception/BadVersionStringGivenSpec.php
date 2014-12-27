<?php

namespace spec\Behat\Borg\Package\Exception;

use Behat\Borg\Package\Exception\PackageException;
use LogicException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BadVersionStringGivenSpec extends ObjectBehavior
{
    function it_is_a_package_exception()
    {
        $this->shouldHaveType(PackageException::class);
    }

    function it_is_also_a_logic_exception()
    {
        $this->shouldHaveType(LogicException::class);
    }
}
