<?php

namespace Fake\Package;

use Behat\Borg\Release\Downloader\Download;

interface PackageDownload extends Download
{
    public function package();
}
