<?php

namespace Behat\Borg\Release;

use Behat\Borg\Release\Downloader\Downloader;
use Behat\Borg\Release\Listener\DownloadListener;
use Behat\Borg\Release\Listener\ReleaseListener;

/**
 * Downloads all new releases using downloader.
 */
final class ReleaseDownloader implements ReleaseListener
{
    /**
     * @var Downloader
     */
    private $downloader;
    /**
     * @var DownloadListener[]
     */
    private $listeners = [];

    /**
     * Initializes listener.
     *
     * @param Downloader $downloader
     */
    public function __construct(Downloader $downloader)
    {
        $this->downloader = $downloader;
    }

    /**
     * Registers new download listener.
     *
     * @param DownloadListener $listener
     */
    public function registerListener(DownloadListener $listener)
    {
        $this->listeners[] = $listener;
    }

    /**
     * {@inheritdoc}
     */
    public function releaseReceived(Release $release)
    {
        $downloadedRelease = $this->downloader->download($release);

        foreach ($this->listeners as $listener) {
            $listener->releaseWasDownloaded($downloadedRelease);
        }
    }
}
