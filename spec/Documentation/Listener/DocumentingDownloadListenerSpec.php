<?php

namespace spec\Behat\Borg\Documentation\Listener;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Builder\DocumentationBuilder;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\Documentation\Finder\DocumentationFinder;
use Behat\Borg\Documentation\Listener\DocumentationBuildListener;
use Behat\Borg\Package\Downloader\DownloadedRelease;
use Behat\Borg\Package\Listener\ReleaseDownloadListener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentingDownloadListenerSpec extends ObjectBehavior
{
    function let(DocumentationFinder $finder, DocumentationBuilder $builder)
    {
        $this->beConstructedWith($finder, $builder);
    }

    function it_is_download_listener()
    {
        $this->shouldHaveType(ReleaseDownloadListener::class);
    }

    function it_builds_found_documentation_using_builder_and_notifies_listeners(
        DocumentationId $anId,
        DocumentationSource $source,
        DownloadedRelease $release,
        DocumentationFinder $finder,
        DocumentationBuilder $builder,
        BuiltDocumentation $builtDocumentation,
        DocumentationBuildListener $listener1,
        DocumentationBuildListener $listener2
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new \DateTimeImmutable()
        );
        $finder->findDocumentation($release)->willReturn($documentation);
        $builder->build($documentation)->willReturn($builtDocumentation);

        $listener1->documentationWasBuilt($builtDocumentation)->shouldBeCalled();
        $listener2->documentationWasBuilt($builtDocumentation)->shouldBeCalled();

        $this->registerListener($listener1);
        $this->registerListener($listener2);

        $this->releaseWasDownloaded($release);
    }

    function it_does_not_build_documentation_if_finder_does_not_find_any(
        DownloadedRelease $release,
        DocumentationFinder $finder,
        DocumentationBuilder $builder,
        DocumentationBuildListener $listener
    ) {
        $finder->findDocumentation($release)->willReturn(null);

        $builder->build(Argument::any())->shouldNotBeCalled();
        $listener->documentationWasBuilt(Argument::any())->shouldNotBeCalled();

        $this->registerListener($listener);

        $this->releaseWasDownloaded($release);
    }
}
