<?php

namespace Behat\Borg\Package;

use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Version;
use DateTimeImmutable;

/**
 * Represents a downloaded version of a package.
 */
final class PackageDownload
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
     *
     * @return PackageDownload
     */
    public static function packageWasDownloaded(Package $package, Download $download)
    {
        $packageDownload = new PackageDownload();
        $packageDownload->package = $package;
        $packageDownload->download = $download;

        return $packageDownload;
    }

    /**
     * Returns package.
     *
     * @return Package
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Returns package version.
     *
     * @return Version
     */
    public function getVersion()
    {
        return $this->download->getVersion();
    }

    /**
     * Returns download.
     *
     * @return Download
     */
    public function getDownload()
    {
        return $this->download;
    }

    /**
     * Returns package release time.
     *
     * @return DateTimeImmutable
     */
    public function getReleaseTime()
    {
        return $this->download->getReleaseTime();
    }

    private function __construct() { }
}
