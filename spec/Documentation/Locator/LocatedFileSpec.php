<?php

namespace spec\Behat\Borg\Documentation\Locator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LocatedFileSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('atPath', ['/some/path']);
    }

    function it_holds_a_path()
    {
        $this->getAbsolutePath()->shouldReturn('/some/path');
    }

    function it_can_be_converted_to_string()
    {
        $this->__toString()->shouldReturn('/some/path');
    }
}
