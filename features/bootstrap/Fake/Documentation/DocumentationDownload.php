<?php

namespace Fake\Documentation;

use Behat\Borg\Release\Downloader\Download;

interface DocumentationDownload extends Download
{
    public function source();
}
