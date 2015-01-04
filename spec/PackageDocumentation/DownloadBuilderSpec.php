<?php

namespace spec\Behat\Borg\PackageDocumentation;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Documentation\Listener\BuildListener;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\Documentation\Source;
use Behat\Borg\DocumentationManager;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Listener\DownloadListener;
use Behat\Borg\Release\Package;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DownloadBuilderSpec extends ObjectBehavior
{
    function let(SourceFinder $finder, Publisher $publisher, Builder $builder)
    {
        $manager = new DocumentationManager($builder->getWrappedObject(), $publisher->getWrappedObject());
        $this->beConstructedWith($finder, $manager);
    }

    function it_is_a_release_download_listener()
    {
        $this->shouldHaveType(DownloadListener::class);
    }

    function it_builds_found_documentation_using_builder_and_notifies_listeners(
        Package $package,
        Source $source,
        Download $download,
        SourceFinder $finder,
        Builder $builder,
        BuiltDocumentation $builtDocumentation
    ) {
        $finder->findSource($download)->willReturn($source);
        $release = new Release($package->getWrappedObject(), Version::string('v2.5'));
        $download->getRelease()->willReturn($release);
        $download->getReleaseTime()->willReturn(new \DateTimeImmutable());

        $builder->build(Argument::which('getSource', $source->getWrappedObject()))->willReturn(
            $builtDocumentation
        )->shouldBeCalled();

        $this->releaseWasDownloaded($download);
    }

    function it_does_not_build_documentation_if_finder_does_not_find_any(
        Download $release,
        SourceFinder $finder,
        Builder $builder
    ) {
        $finder->findSource($release)->willReturn(null);

        $builder->build(Argument::any())->shouldNotBeCalled();

        $this->releaseWasDownloaded($release);
    }
}
