<?php

namespace Fake\Package;

use Behat\Borg\Release\Downloader\Download;

interface PackagedDownload extends Download
{
    public function getPackage();
}
