<?php

namespace Fake\Documentation;

use Behat\Borg\Release\Downloader\Download;

interface DocumentedDownload extends Download
{
    public function getSource();
}
