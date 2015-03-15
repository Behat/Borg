<?php

namespace spec\Behat\Borg\Extension\Exception;

use Behat\Borg\Extension\Exception\ExtensionException;
use LogicException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExtensionNotFoundSpec extends ObjectBehavior
{
    function it_is_an_extension_exception()
    {
        $this->shouldHaveType(ExtensionException::class);
    }

    function it_is_also_a_logic_exception()
    {
        $this->shouldHaveType(LogicException::class);
    }
}
