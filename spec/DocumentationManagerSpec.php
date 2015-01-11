<?php

namespace spec\Behat\Borg;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Finder\PageFinder;
use Behat\Borg\Documentation\Processor\Processor;
use Behat\Borg\Documentation\RawDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Page\Page;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Repository\Repository;
use Behat\Borg\Documentation\Source;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationManagerSpec extends ObjectBehavior
{
    function let(Processor $processor, PageFinder $pageFinder, Repository $repository)
    {
        $this->beConstructedWith($processor, $pageFinder, $repository);
    }

    function it_processes_documentation_using_processor(
        DocumentationId $anId,
        Source $source,
        Processor $processor
    ) {
        $raw = new RawDocumentation(
            $anId->getWrappedObject(), new \DateTimeImmutable(), $source->getWrappedObject()
        );

        $processor->process($raw)->shouldBeCalled();

        $this->process($raw);
    }

    function it_finds_pages_using_finder(
        PageFinder $pageFinder,
        DocumentationId $anId,
        BuiltDocumentation $built
    ) {
        $built->getDocumentationId()->willReturn($anId);
        $built->getBuildTime()->willReturn(new \DateTimeImmutable());
        $built->getDocumentationTime()->willReturn(new \DateTimeImmutable());

        $pageId = new PageId(basename(__FILE__));
        $publishedDocumentation = PublishedDocumentation::publish($built->getWrappedObject(), __DIR__);
        $page = new Page($publishedDocumentation, $pageId);

        $pageFinder->findPage($anId, $pageId)->willReturn($page);

        $this->findPage($anId, $pageId)->shouldReturn($page);
    }

    function it_finds_all_documentation_for_a_provided_project_name(
        Repository $repository,
        DocumentationId $anId,
        BuiltDocumentation $built
    ) {
        $built->getDocumentationId()->willReturn($anId);
        $built->getBuildTime()->willReturn(new \DateTimeImmutable());
        $built->getDocumentationTime()->willReturn(new \DateTimeImmutable());

        $publishedDocumentation = PublishedDocumentation::publish(
            $built->getWrappedObject(), __DIR__
        );

        $repository->findForProject('my/project')->willReturn([$publishedDocumentation]);

        $this->getAvailableDocumentation('my/project')->shouldReturn([$publishedDocumentation]);
    }
}
