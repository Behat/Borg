<?php

namespace spec\Behat\Borg;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Page\Page;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\Documentation\Source;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationManagerSpec extends ObjectBehavior
{
    function let(Builder $builder, Publisher $publisher)
    {
        $this->beConstructedWith($builder, $publisher);
    }

    function it_builds_documentation_using_builder_and_publishes_it_using_publisher(
        Builder $builder,
        DocumentationId $anId,
        Source $source,
        BuiltDocumentation $builtDocumentation,
        Publisher $publisher
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), new \DateTimeImmutable(), $source->getWrappedObject()
        );

        $builder->build($documentation)->willReturn($builtDocumentation);
        $publisher->publish($builtDocumentation)->shouldBeCalled();

        $this->build($documentation);
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
        $publishedDocumentation = PublishedDocumentation::publish(
            $built->getWrappedObject(), __DIR__
        );

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
