<?php

namespace spec\Behat\Borg;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\File\FileLocator;
use Behat\Borg\Documentation\File\PublishedFile;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Publisher\Publisher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationManagerSpec extends ObjectBehavior
{
    function let(Publisher $publisher)
    {
        $this->beConstructedWith($publisher);
    }

    function it_locates_documentation_file_if_it_is_published_and_file_exists(
        Publisher $publisher,
        DocumentationId $anId,
        BuiltDocumentation $built
    ) {
        $locator = FileLocator::ofDocumentationFile($anId->getWrappedObject(), basename(__FILE__));
        $publishedDocumentation = PublishedDocumentation::publish($built->getWrappedObject(), __DIR__);

        $publisher->hasPublished($anId)->willReturn(true);
        $publisher->getPublished($anId)->willReturn($publishedDocumentation);

        $locatedFile = $this->findFile($locator);
        $locatedFile->shouldBeAnInstanceOf(PublishedFile::class);
        $locatedFile->getAbsolutePath()->shouldReturn(__FILE__);
    }

    function it_returns_null_if_documentation_was_not_published(Publisher $publisher, DocumentationId $anId)
    {
        $locator = FileLocator::ofDocumentationFile($anId->getWrappedObject(), basename(__FILE__));

        $publisher->hasPublished($anId)->willReturn(false);

        $this->findFile($locator)->shouldReturn(null);
    }

    function it_returns_null_if_documentation_is_published_but_file_does_not_exist(
        Publisher $publisher,
        DocumentationId $anId,
        BuiltDocumentation $built
    ) {
        $locator = FileLocator::ofDocumentationFile($anId->getWrappedObject(), 'no_file');
        $publishedDocumentation = PublishedDocumentation::publish(
            $built->getWrappedObject(), __DIR__
        );

        $publisher->hasPublished($anId)->willReturn(true);
        $publisher->getPublished($anId)->willReturn($publishedDocumentation);

        $this->findFile($locator)->shouldReturn(null);
    }
}
