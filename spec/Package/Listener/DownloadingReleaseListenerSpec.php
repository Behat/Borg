<?php

namespace spec\Behat\Borg\Package\Listener;

use Behat\Borg\Package\Downloader\Download;
use Behat\Borg\Package\Downloader\ReleaseDownloader;
use Behat\Borg\Package\Listener\DownloadingReleaseListener;
use Behat\Borg\Package\Listener\ReleaseDownloadListener;
use Behat\Borg\Package\Listener\ReleaseListener;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DownloadingReleaseListenerSpec extends ObjectBehavior
{
    function let(ReleaseDownloader $downloader)
    {
        $this->beConstructedWith($downloader);
    }

    function it_is_a_listener()
    {
        $this->shouldHaveType(ReleaseListener::class);
    }

    function it_downloads_new_release_using_downloader_and_notifies_registered_listeners(
        Package $package,
        ReleaseDownloader $downloader,
        Download $downloadedRelease,
        ReleaseDownloadListener $listener1,
        ReleaseDownloadListener $listener2
    ) {
        $release = new Release($package->getWrappedObject(), Version::string('v2.5'));
        $downloader->downloadRelease($release)->willReturn($downloadedRelease);

        $listener1->releaseWasDownloaded($downloadedRelease)->shouldBeCalled();
        $listener2->releaseWasDownloaded($downloadedRelease)->shouldBeCalled();

        $this->registerListener($listener1);
        $this->registerListener($listener2);

        $this->packageWasReleased($release);
    }
}
