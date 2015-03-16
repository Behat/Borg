<?php

namespace Behat\Borg\Release;

use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Downloader\DownloadedPackage;
use Behat\Borg\Release\Listener\DownloadListener;
use Behat\Borg\Release\Listener\PackageListener;
use Behat\Borg\Release\PackageFinder\PackageFinder;

/**
 * Tries to find a package in provided release downloads.
 */
final class ReleasePackager implements DownloadListener
{
    /**
     * @var PackageFinder
     */
    private $finder;
    /**
     * @var PackageListener[]
     */
    private $listeners = [];

    /**
     * Initializes packager.
     *
     * @param PackageFinder $finder
     */
    public function __construct(PackageFinder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * Registers listener.
     *
     * @param PackageListener $listener
     */
    public function registerListener(PackageListener $listener)
    {
        $this->listeners[] = $listener;
    }

    /**
     * {@inheritdoc}
     */
    public function releaseDownloaded(Download $download)
    {
        if (!$package = $this->finder->find($download)) {
            return;
        }

        $downloadedPackage = new DownloadedPackage($package, $download);

        foreach ($this->listeners as $listener) {
            $listener->packageDownloaded($downloadedPackage);
        }
    }
}
