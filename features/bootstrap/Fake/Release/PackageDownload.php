<?php

namespace Fake\Release;

use Behat\Borg\Release\Downloader\Download;

interface PackageDownload extends Download
{
    public function package();
}
