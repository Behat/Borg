<?php

namespace Behat\Borg\Package;

use Behat\Borg\Release\Downloader\Download;

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

    public static function packageWasDownloaded(Package $package, Download $download)
    {
        $packageDownload = new PackageDownload();
        $packageDownload->package = $package;
        $packageDownload->download = $download;

        return $packageDownload;
    }

    public function getPackage()
    {
        return $this->package;
    }

    public function getDownload()
    {
        return $this->download;
    }

    private function __construct() { }
}
