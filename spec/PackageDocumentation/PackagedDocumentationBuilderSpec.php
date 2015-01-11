<?php

namespace spec\Behat\Borg\PackageDocumentation;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\Documentation\Source;
use Behat\Borg\DocumentationManager;
use Behat\Borg\Package\Listener\PackageListener;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\PackageDownload;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PackagedDocumentationBuilderSpec extends ObjectBehavior
{
    function let(SourceFinder $finder, Publisher $publisher, Builder $builder)
    {
        $manager = new DocumentationManager($builder->getWrappedObject(), $publisher->getWrappedObject());
        $this->beConstructedWith($finder, $manager);
    }

    function it_is_a_package_listener()
    {
        $this->shouldHaveType(PackageListener::class);
    }

    function it_builds_the_found_documentation_and_notifies_listeners(
        Package $package,
        Download $download,
        SourceFinder $finder,
        Source $source,
        Builder $builder,
        BuiltDocumentation $builtDocumentation
    ) {
        $packageDownload = new PackageDownload($package->getWrappedObject(), $download->getWrappedObject());
        $finder->findSource($download)->willReturn($source);
        $download->getVersion()->willReturn(Version::string('v2.5'));
        $download->getReleaseTime()->willReturn(new \DateTimeImmutable());

        $builder->build(Argument::which('getSource', $source->getWrappedObject()))->willReturn(
            $builtDocumentation
        )->shouldBeCalled();

        $this->packageWasDownloaded($packageDownload);
    }

    function it_does_not_build_documentation_if_finder_does_not_find_any_source(
        Package $package,
        Download $download,
        SourceFinder $finder,
        SourceFinder $finder,
        Builder $builder
    ) {
        $packageDownload = new PackageDownload($package->getWrappedObject(), $download->getWrappedObject());
        $finder->findSource($download)->willReturn(null);

        $builder->build(Argument::any())->shouldNotBeCalled();

        $this->packageWasDownloaded($packageDownload);
    }
}
