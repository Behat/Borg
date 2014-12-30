<?php

namespace spec\Behat\Borg\Documentation\File;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PublishedFileSpec extends ObjectBehavior
{
    function let(BuiltDocumentation $built)
    {
        $this->beConstructedThrough(
            'publishedAtPath', [PublishedDocumentation::publish($built->getWrappedObject(), '/path'), 'relative/path']
        );
    }

    function it_holds_a_reference_to_published_documentation(BuiltDocumentation $built)
    {
        $this->getDocumentation()->shouldBeLike(PublishedDocumentation::publish($built->getWrappedObject(), '/path'));
    }

    function it_can_product_a_relative_path()
    {
        $this->getRelativePath()->shouldReturn('relative/path');
    }

    function it_can_product_an_absolute_path()
    {
        $this->getAbsolutePath()->shouldReturn('/path/relative/path');
    }

    function it_can_be_converted_to_string()
    {
        $this->__toString()->shouldReturn('/path/relative/path');
    }
}
