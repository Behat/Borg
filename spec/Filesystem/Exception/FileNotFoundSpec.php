<?php

namespace spec\Behat\Borg\Filesystem\Exception;

use Behat\Borg\Filesystem\Exception\FilesystemException;
use LogicException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileNotFoundSpec extends ObjectBehavior
{
    function it_is_a_filesystem_exception()
    {
        $this->shouldHaveType(FilesystemException::class);
    }

    function it_also_is_a_logic_exception()
    {
        $this->shouldHaveType(LogicException::class);
    }
}
