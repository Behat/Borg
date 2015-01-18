<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Release\Downloader\Download;

final class FakeSourceFinder implements SourceFinder
{
    public function find(Download $download)
    {
        if ($download instanceof DocumentationDownload) {
            return $download->source();
        }

        return null;
    }
}
