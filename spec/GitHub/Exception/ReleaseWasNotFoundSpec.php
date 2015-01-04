<?php

namespace spec\Behat\Borg\GitHub\Exception;

use Behat\Borg\Release\Exception\RepositoryException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RuntimeException;

class ReleaseWasNotFoundSpec extends ObjectBehavior
{
    function it_is_a_package_exception()
    {
        $this->shouldHaveType(RepositoryException::class);
    }

    function it_is_also_a_runtime_exception()
    {
        $this->shouldHaveType(RuntimeException::class);
    }
}
