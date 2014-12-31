<?php

namespace spec\Behat\Borg\Documentation\Page;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PageIdSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('/doc/path');
    }

    function it_represents_a_path()
    {
        $this->getPath()->shouldReturn('/doc/path');
    }

    function it_can_be_converted_to_string()
    {
        $this->__toString()->shouldReturn('/doc/path');
    }
}
