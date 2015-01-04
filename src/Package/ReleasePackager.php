<?php

namespace Behat\Borg\Package;

use Behat\Borg\Package\Finder\PackageFinder;
use Behat\Borg\Package\Listener\PackageListener;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Listener\DownloadListener;

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

    public function __construct(PackageFinder $finder)
    {
        $this->finder = $finder;
    }

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

        $packageDownload = PackageDownload::packageWasDownloaded($package, $download);

        foreach ($this->listeners as $listener) {
            $listener->packageWasDownloaded($packageDownload);
        }
    }
}
