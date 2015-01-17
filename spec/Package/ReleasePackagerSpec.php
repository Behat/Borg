<?php

namespace spec\Behat\Borg\Package;

use Behat\Borg\Package\Finder\PackageFinder;
use Behat\Borg\Package\Listener\PackageListener;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\PackageDownload;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Listener\DownloadListener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReleasePackagerSpec extends ObjectBehavior
{
    function let(PackageFinder $finder)
    {
        $this->beConstructedWith($finder);
    }

    function it_is_a_release_download_listener()
    {
        $this->shouldHaveType(DownloadListener::class);
    }

    function it_notifies_listeners_when_package_is_found_inside_a_download(
        Download $download,
        PackageFinder $finder,
        Package $package,
        PackageListener $listener1,
        PackageListener $listener2
    ) {
        $finder->find($download)->willReturn($package);
        $packageDownload = new PackageDownload($package->getWrappedObject(), $download->getWrappedObject());

        $listener1->packageWasDownloaded($packageDownload)->shouldBeCalled();
        $listener2->packageWasDownloaded($packageDownload)->shouldBeCalled();

        $this->registerListener($listener1);
        $this->registerListener($listener2);

        $this->releaseWasDownloaded($download);
    }

    function it_does_not_notify_listeners_when_package_is_not_found_inside_a_download(
        Download $download,
        PackageFinder $finder,
        PackageListener $listener
    ) {
        $finder->find($download)->willReturn(null);

        $listener->packageWasDownloaded(Argument::any())->shouldNotBeCalled();

        $this->registerListener($listener);

        $this->releaseWasDownloaded($download);
    }
}
