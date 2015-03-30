<?php

namespace spec\Behat\Borg;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Exception\PageNotFound;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\Documentation\RawDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Page\Page;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Repository\Repository;
use Behat\Borg\Documentation\Source;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumenterSpec extends ObjectBehavior
{
    function let(Builder $builder, Publisher $publisher, Repository $repository)
    {
        $this->beConstructedWith($builder, $publisher, $repository);
    }

    function it_processes_documentation_by_building_and_publishing_it(
        Builder $builder,
        Source $source,
        BuiltDocumentation $builtDocumentation,
        Publisher $publisher,
        Repository $repository
    ) {
        $anId = new DocumentationId('behat/behat', 'v1.0');
        $raw = new RawDocumentation(
            $anId, new \DateTimeImmutable(), $source->getWrappedObject()
        );
        $published = PublishedDocumentation::publish($builtDocumentation->getWrappedObject(), '/');

        $builder->build($raw)->willReturn($builtDocumentation);
        $publisher->publish($builtDocumentation)->willReturn($published);
        $repository->add($published)->shouldBeCalled();

        $this->process($raw);
    }

    function it_finds_documentation_page_if_documentation_was_saved_and_has_asked_page(
        Repository $repository,
        BuiltDocumentation $built
    ) {

        $anId = new DocumentationId('behat/behat', 'v1.0');
        $built->documentationId()->willReturn($anId);
        $built->builtAt()->willReturn(new \DateTimeImmutable());
        $built->documentedAt()->willReturn(new \DateTimeImmutable());

        $pageId = new PageId(basename(__FILE__));
        $publishedDocumentation = PublishedDocumentation::publish(
            $built->getWrappedObject(), __DIR__
        );

        $repository->documentation($anId)->willReturn($publishedDocumentation);

        $page = $this->documentationPage($anId, $pageId);
        $page->shouldBeAnInstanceOf(Page::class);
    }

    function it_finds_nothing_if_documentation_was_found_but_the_page_was_not(
        Repository $repository,
        BuiltDocumentation $built
    ) {
        $anId = new DocumentationId('behat/behat', 'v1.0');
        $pageId = new PageId('no_file');
        $publishedDocumentation = PublishedDocumentation::publish(
            $built->getWrappedObject(), __DIR__
        );

        $repository->documentation($anId)->willReturn($publishedDocumentation);

        $this->shouldThrow(PageNotFound::class)->duringDocumentationPage($anId, $pageId);
    }

    function it_finds_all_documentation_for_a_provided_project_name(
        Repository $repository,
        BuiltDocumentation $built
    ) {
        $anId = new DocumentationId('behat/behat', 'v1.0');
        $built->documentationId()->willReturn($anId);
        $built->builtAt()->willReturn(new \DateTimeImmutable());
        $built->documentedAt()->willReturn(new \DateTimeImmutable());

        $publishedDocumentation = PublishedDocumentation::publish(
            $built->getWrappedObject(), __DIR__
        );

        $repository->allProjectDocumentation('my/project')->willReturn([$publishedDocumentation]);

        $this->allProjectDocumentation('my/project')->shouldReturn([$publishedDocumentation]);
    }
}
