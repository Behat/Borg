<?php

namespace spec\Behat\Borg\Documentation\Page;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PageSpec extends ObjectBehavior
{
    function let(BuiltDocumentation $built)
    {
        $this->beConstructedWith(
            PublishedDocumentation::publish($built->getWrappedObject(), __DIR__), new PageId(basename(__FILE__))
        );
    }

    function it_has_a_path()
    {
        $this->getPath()->shouldReturn(__FILE__);
    }

    function it_can_be_converted_to_string()
    {
        $this->__toString()->shouldReturn(__FILE__);
    }
}
