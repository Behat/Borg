<?php

namespace spec\Behat\Borg\Documentation\Finder;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Finder\PageFinder;
use Behat\Borg\Documentation\Page\Page;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Repository\Repository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RepositoryPageFinderSpec extends ObjectBehavior
{
    function let(Repository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_page_finder()
    {
        $this->shouldHaveType(PageFinder::class);
    }

    function it_finds_documentation_page_if_documentation_was_saved_and_has_asked_page(
        Repository $repository,
        DocumentationId $anId,
        BuiltDocumentation $built
    ) {
        $built->getDocumentationId()->willReturn($anId);
        $built->getBuildTime()->willReturn(new \DateTimeImmutable());
        $built->getDocumentationTime()->willReturn(new \DateTimeImmutable());

        $pageId = new PageId(basename(__FILE__));
        $publishedDocumentation = PublishedDocumentation::publish(
            $built->getWrappedObject(), __DIR__
        );

        $repository->find($anId)->willReturn($publishedDocumentation);

        $page = $this->findPage($anId, $pageId);
        $page->shouldBeAnInstanceOf(Page::class);
        $page->getPath()->shouldReturn(__FILE__);
    }

    function it_finds_nothing_if_documentation_was_not_found(
        Repository $repository,
        DocumentationId $anId
    ) {
        $pageId = new PageId(basename(__FILE__));

        $repository->find($anId)->willReturn(null);

        $this->findPage($anId, $pageId)->shouldReturn(null);
    }

    function it_finds_nothing_if_documentation_was_found_but_page_was_not(
        Repository $repository,
        DocumentationId $anId,
        BuiltDocumentation $built
    ) {
        $pageId = new PageId('no_file');
        $publishedDocumentation = PublishedDocumentation::publish(
            $built->getWrappedObject(), __DIR__
        );

        $repository->find($anId)->willReturn($publishedDocumentation);

        $this->findPage($anId, $pageId)->shouldReturn(null);
    }
}
