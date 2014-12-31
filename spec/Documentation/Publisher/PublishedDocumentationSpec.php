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
        DocumentationId $anId,
        \DateTimeImmutable $buildTime,
        \DateTimeImmutable $docTime
    ) {
        $builtDocumentation->getDocumentationId()->willReturn($anId);
        $builtDocumentation->getBuildTime()->willReturn($buildTime);
        $builtDocumentation->getDocumentationTime()->willReturn($docTime);

        $this->beConstructedThrough('publish', [$builtDocumentation, __DIR__]);
    }

    function it_has_documentation_id(DocumentationId $anId)
    {
        $this->getDocumentationId()->shouldReturn($anId);
    }

    function it_has_the_same_build_time_as_built_documentation(\DateTimeImmutable $buildTime)
    {
        $this->getBuildTime()->shouldReturn($buildTime);
    }

    function it_has_the_same_documentation_time_as_built_documentation(\DateTimeImmutable $docTime)
    {
        $this->getDocumentationTime()->shouldReturn($docTime);
    }

    function it_can_tell_if_it_contains_a_page(DocumentationId $anId)
    {
        $this->shouldHavePage(new PageId(basename(__FILE__)));
        $this->shouldNotHavePage(new PageId('any file'));
    }

    function it_can_get_page_by_its_id()
    {
        $pageId = new PageId(basename(__FILE__));

        $this->getPage($pageId)->shouldBeLike(new Page($this->getWrappedObject(), $pageId));
    }

    function it_throws_an_exception_when_trying_to_get_inexistent_page()
    {
        $this->shouldThrow()->duringGetPage(new PageId('any file'));
    }

    function it_can_provide_absolute_path_to_provided_page()
    {
        $this->getPagePath(new PageId(basename(__FILE__)))->shouldReturn(__FILE__);
    }

    function it_throws_an_exception_when_trying_to_get_path_for_inexistent_page()
    {
        $this->shouldThrow()->duringGetPagePath(new PageId('any file'));
    }
}
