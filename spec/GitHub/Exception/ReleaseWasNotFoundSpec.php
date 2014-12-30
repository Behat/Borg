<?php

namespace spec\Behat\Borg\GitHub\Exception;

use Behat\Borg\Package\Exception\PackageException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RuntimeException;

class ReleaseWasNotFoundSpec extends ObjectBehavior
{
    function it_is_a_package_exception()
    {
        $this->shouldHaveType(PackageException::class);
    }

    function it_is_also_a_runtime_exception()
    {
        $this->shouldHaveType(RuntimeException::class);
    }
}
