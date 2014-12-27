<?php

namespace spec\Behat\Borg\Documentation\Listener;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Source;
use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Documentation\Listener\DocumentationBuildListener;
use Behat\Borg\Package\Downloader\Download;
use Behat\Borg\Package\Listener\ReleaseDownloadListener;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentingDownloadListenerSpec extends ObjectBehavior
{
    function let(SourceFinder $finder, Builder $builder)
    {
        $this->beConstructedWith($finder, $builder);
    }

    function it_is_download_listener()
    {
        $this->shouldHaveType(ReleaseDownloadListener::class);
    }

    function it_builds_found_documentation_using_builder_and_notifies_listeners(
        Package $package,
        Source $source,
        Download $download,
        SourceFinder $finder,
        Builder $builder,
        BuiltDocumentation $builtDocumentation,
        DocumentationBuildListener $listener1,
        DocumentationBuildListener $listener2
    ) {
        $finder->findDocumentationSource($download)->willReturn($source);
        $release = new Release($package->getWrappedObject(), Version::string('v2.5'));
        $download->getRelease()->willReturn($release);
        $download->getReleaseTime()->willReturn(new \DateTimeImmutable());
        $builder->buildDocumentation(Argument::which('getSource', $source->getWrappedObject()))->willReturn(
            $builtDocumentation
        );

        $listener1->documentationWasBuilt($builtDocumentation)->shouldBeCalled();
        $listener2->documentationWasBuilt($builtDocumentation)->shouldBeCalled();

        $this->registerListener($listener1);
        $this->registerListener($listener2);

        $this->releaseWasDownloaded($download);
    }

    function it_does_not_build_documentation_if_finder_does_not_find_any(
        Download $release,
        SourceFinder $finder,
        Builder $builder,
        DocumentationBuildListener $listener
    ) {
        $finder->findDocumentationSource($release)->willReturn(null);

        $builder->buildDocumentation(Argument::any())->shouldNotBeCalled();
        $listener->documentationWasBuilt(Argument::any())->shouldNotBeCalled();

        $this->registerListener($listener);

        $this->releaseWasDownloaded($release);
    }
}
