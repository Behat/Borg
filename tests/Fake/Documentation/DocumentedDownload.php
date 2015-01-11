<?php

namespace tests\Behat\Borg\Fake\Documentation;

use Behat\Borg\Release\Downloader\Download;

interface DocumentedDownload extends Download
{
    public function getSource();
}
