<?php

namespace spec\Behat\Borg;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Exception\PageNotFound;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Page\Page;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Repository\Repository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumenterSpec extends ObjectBehavior
{
    function let(Repository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_finds_documentation_page_if_documentation_was_saved_and_has_asked_page(
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

        $repository->documentation($anId)->willReturn($publishedDocumentation);

        $page = $this->documentationPage('behat/behat', 'v1.0', basename(__FILE__));
        $page->shouldBeAnInstanceOf(Page::class);
    }

    function it_finds_nothing_if_documentation_was_found_but_the_page_was_not(
        Repository $repository,
        BuiltDocumentation $built
    ) {
        $anId = new DocumentationId('behat/behat', 'v1.0');
        $publishedDocumentation = PublishedDocumentation::publish(
            $built->getWrappedObject(), __DIR__
        );

        $repository->documentation($anId)->willReturn($publishedDocumentation);

        $this->shouldThrow(PageNotFound::class)->duringDocumentationPage('behat/behat', 'v1.0', 'no_file');
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
