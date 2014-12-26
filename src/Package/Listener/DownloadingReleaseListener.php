<?php

namespace Behat\Borg\Package\Listener;

use Behat\Borg\Package\Downloader\ReleaseDownloader;
use Behat\Borg\Package\Release;

final class DownloadingReleaseListener implements ReleaseListener
{
    private $downloader;
    private $listeners = [];

    public function __construct(ReleaseDownloader $downloader)
    {
        $this->downloader = $downloader;
    }

    public function registerListener(ReleaseDownloadListener $listener)
    {
        $this->listeners[] = $listener;
    }

    /**
     * {@inheritdoc}
     */
    public function packageWasReleased(Release $release)
    {
        $downloadedRelease = $this->downloader->downloadRelease($release);

        foreach ($this->listeners as $listener) {
            $listener->releaseWasDownloaded($downloadedRelease);
        }
    }
}
