<?php

namespace spec\Behat\Borg\Documentation\Exception;

use Behat\Borg\Documentation\Exception\DocumentationException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RuntimeException;

class BuildFailedSpec extends ObjectBehavior
{
    function it_is_a_documentation_exception()
    {
        $this->shouldHaveType(DocumentationException::class);
    }

    function it_is_also_a_runtime_exception()
    {
        $this->shouldHaveType(RuntimeException::class);
    }
}
