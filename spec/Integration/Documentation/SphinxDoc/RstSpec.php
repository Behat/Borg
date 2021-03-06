<?php

namespace spec\Behat\Borg\Integration\Documentation\SphinxDoc;

use Behat\Borg\Documentation\Source;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RstSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('atPath', [__DIR__]);
    }

    function it_is_a_documentation_source()
    {
        $this->shouldHaveType(Source::class);
    }

    function it_holds_the_path_to_all_its_RST_documents()
    {
        $this->path()->shouldReturn(__DIR__);
    }
}
