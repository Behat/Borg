<?php

namespace spec\Behat\Borg\Documentation\Publisher;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Page\Page;
use Behat\Borg\Documentation\Page\PageId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PublishedDocumentationSpec extends ObjectBehavior
{
    function let(
        BuiltDocumentation $builtDocumentation,
        \DateTimeImmutable $buildTime,
        \DateTimeImmutable $docTime
    ) {
        $builtDocumentation->documentationId()->willReturn(new DocumentationId('behat/behat', 'v1.0'));
        $builtDocumentation->builtAt()->willReturn($buildTime);
        $builtDocumentation->documentedAt()->willReturn($docTime);

        $this->beConstructedThrough('publish', [$builtDocumentation, __DIR__]);
    }

    function it_has_a_documentation_id()
    {
        $this->documentationId()->shouldBeLike(new DocumentationId('behat/behat', 'v1.0'));
    }

    function it_has_the_same_build_time_as_the_built_documentation(\DateTimeImmutable $buildTime)
    {
        $this->builtAt()->shouldReturn($buildTime);
    }

    function it_has_the_same_documentation_time_as_the_built_documentation(\DateTimeImmutable $docTime)
    {
        $this->documentedAt()->shouldReturn($docTime);
    }

    function it_can_tell_if_it_contains_a_page()
    {
        $this->has(new PageId(basename(__FILE__)))->shouldReturn(true);
        $this->has(new PageId('any file'))->shouldReturn(false);
    }

    function it_can_get_a_page_by_its_id()
    {
        $pageId = new PageId(basename(__FILE__));

        $this->page($pageId)->shouldBeLike(new Page($this->getWrappedObject(), $pageId));
    }

    function it_throws_an_exception_when_trying_to_get_inexistent_page()
    {
        $this->shouldThrow()->duringPage(new PageId('any file'));
    }

    function it_can_provide_absolute_path_for_the_page_by_its_id()
    {
        $this->path(new PageId(basename(__FILE__)))->shouldReturn(__FILE__);
    }

    function it_throws_an_exception_when_trying_to_get_path_for_inexistent_page()
    {
        $this->shouldThrow()->duringPath(new PageId('any file'));
    }
}
