<?php

namespace spec\Behat\Borg\Release;

use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Downloader\DownloadedPackage;
use Behat\Borg\Release\Listener\DownloadListener;
use Behat\Borg\Release\Listener\PackageListener;
use Behat\Borg\Release\Package;
use Behat\Borg\Release\PackageFinder\PackageFinder;
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
        $packageDownload = new DownloadedPackage($package->getWrappedObject(), $download->getWrappedObject());

        $listener1->packageDownloaded($packageDownload)->shouldBeCalled();
        $listener2->packageDownloaded($packageDownload)->shouldBeCalled();

        $this->registerListener($listener1);
        $this->registerListener($listener2);

        $this->releaseDownloaded($download);
    }

    function it_does_not_notify_listeners_when_package_is_not_found_inside_a_download(
        Download $download,
        PackageFinder $finder,
        PackageListener $listener
    ) {
        $finder->find($download)->willReturn(null);

        $listener->packageDownloaded(Argument::any())->shouldNotBeCalled();

        $this->registerListener($listener);

        $this->releaseDownloaded($download);
    }
}
