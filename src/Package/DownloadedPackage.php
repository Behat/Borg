<?php

namespace Behat\Borg\Package;

use Behat\Borg\Release\Downloader\Download;

/**
 * Represents a downloaded version of a package.
 */
final class DownloadedPackage
{
    /**
     * @var Package
     */
    private $package;
    /**
     * @var Download
     */
    private $download;

    /**
     * Initializes download.
     *
     * @param Package  $package
     * @param Download $download
     */
    public function __construct(Package $package, Download $download)
    {
        $this->package = $package;
        $this->download = $download;
    }

    /**
     * Returns package.
     *
     * @return Package
     */
    public function package()
    {
        return $this->package;
    }

    /**
     * Returns download.
     *
     * @return Download
     */
    public function download()
    {
        return $this->download;
    }
}
