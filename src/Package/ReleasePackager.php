<?php

namespace Behat\Borg\Package;

use Behat\Borg\Package\Finder\PackageFinder;
use Behat\Borg\Package\Listener\PackageListener;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Listener\DownloadListener;

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
    public function releaseWasDownloaded(Download $download)
    {
        if (!$package = $this->finder->findPackage($download)) {
            return;
        }

        $packageDownload = new PackageDownload($package, $download);

        foreach ($this->listeners as $listener) {
            $listener->packageWasDownloaded($packageDownload);
        }
    }
}
