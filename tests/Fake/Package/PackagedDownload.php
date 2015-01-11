<?php

namespace tests\Behat\Borg\Fake\Package;

use Behat\Borg\Release\Downloader\Download;

interface PackagedDownload extends Download
{
    public function getPackage();
}
