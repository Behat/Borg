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

    function it_holds_a_page_path_it_was_constructed_with()
    {
        $this->path()->shouldReturn('/doc/path');
    }

    function its_string_representation_is_a_page_path_it_was_constructed_with()
    {
        $this->__toString()->shouldReturn('/doc/path');
    }
}
