<?php

namespace tests\Behat\Borg\Fake\Documentation;

use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Release\Downloader\Download;

final class FakeSourceFinder implements SourceFinder
{
    public function findSource(Download $download)
    {
        if ($download instanceof DocumentedDownload) {
            return $download->getSource();
        }

        return null;
    }
}
