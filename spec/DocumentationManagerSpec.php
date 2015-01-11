<?php

namespace spec\Behat\Borg;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\RawDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Page\Page;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\Documentation\Repository\Repository;
use Behat\Borg\Documentation\Source;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationManagerSpec extends ObjectBehavior
{
    function let(Builder $builder, Publisher $publisher, Repository $repository)
    {
        $this->beConstructedWith($builder, $publisher, $repository);
    }

    function it_processes_documentation_by_building_publishing_and_then_saving_it_to_repository(
        Builder $builder,
        DocumentationId $anId,
        Source $source,
        BuiltDocumentation $builtDocumentation,
        Publisher $publisher,
        Repository $repository
    ) {
        $raw = new RawDocumentation(
            $anId->getWrappedObject(), new \DateTimeImmutable(), $source->getWrappedObject()
        );
        $published = PublishedDocumentation::publish($builtDocumentation->getWrappedObject(), '/');

        $builder->build($raw)->willReturn($builtDocumentation);
        $publisher->publish($builtDocumentation)->willReturn($published);
        $repository->save($published)->shouldBeCalled();

        $this->process($raw);
    }

    function it_can_find_all_published_documentation_for_a_provided_project_name(
        DocumentationId $anId,
        Publisher $publisher,
        BuiltDocumentation $built
    ) {
        $built->getDocumentationId()->willReturn($anId);
        $built->getBuildTime()->willReturn(new \DateTimeImmutable());
        $built->getDocumentationTime()->willReturn(new \DateTimeImmutable());

        $publishedDocumentation = PublishedDocumentation::publish($built->getWrappedObject(), __DIR__);

        $publisher->findForProject('my/project')->willReturn([$publishedDocumentation]);

        $this->getAvailableDocumentation('my/project')->shouldReturn([$publishedDocumentation]);
    }

    function it_locates_documentation_file_if_it_is_published_and_file_exists(
        Publisher $publisher,
        DocumentationId $anId,
        BuiltDocumentation $built
    ) {
        $built->getDocumentationId()->willReturn($anId);
        $built->getBuildTime()->willReturn(new \DateTimeImmutable());
        $built->getDocumentationTime()->willReturn(new \DateTimeImmutable());

        $pageId = new PageId(basename(__FILE__));
        $publishedDocumentation = PublishedDocumentation::publish($built->getWrappedObject(), __DIR__);

        $publisher->hasPublished($anId)->willReturn(true);
        $publisher->getPublished($anId)->willReturn($publishedDocumentation);

        $page = $this->findPage($anId, $pageId);
        $page->shouldBeAnInstanceOf(Page::class);
        $page->getPath()->shouldReturn(__FILE__);
    }

    function it_returns_null_if_documentation_was_not_published(
        Publisher $publisher,
        DocumentationId $anId
    ) {
        $pageId = new PageId(basename(__FILE__));

        $publisher->hasPublished($anId)->willReturn(false);

        $this->findPage($anId, $pageId)->shouldReturn(null);
    }

    function it_returns_null_if_documentation_is_published_but_file_does_not_exist(
        Publisher $publisher,
        DocumentationId $anId,
        BuiltDocumentation $built
    ) {
        $pageId = new PageId('no_file');
        $publishedDocumentation = PublishedDocumentation::publish(
            $built->getWrappedObject(), __DIR__
        );

        $publisher->hasPublished($anId)->willReturn(true);
        $publisher->getPublished($anId)->willReturn($publishedDocumentation);

        $this->findPage($anId, $pageId)->shouldReturn(null);
    }
}
