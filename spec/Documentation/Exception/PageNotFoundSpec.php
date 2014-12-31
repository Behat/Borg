<?php

namespace spec\Behat\Borg\Documentation\Exception;

use Behat\Borg\Documentation\Exception\DocumentationException;
use LogicException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PageNotFoundSpec extends ObjectBehavior
{
    function it_is_a_documentation_exception()
    {
        $this->shouldHaveType(DocumentationException::class);
    }

    function it_is_also_a_logic_exception()
    {
        $this->shouldHaveType(LogicException::class);
    }
}
