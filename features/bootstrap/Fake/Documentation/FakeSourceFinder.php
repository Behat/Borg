<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Package\Downloader\Download;
use Fake\Package\FakeDownload;

final class FakeSourceFinder implements SourceFinder
{
    public function findSource(Download $download)
    {
        if ($download instanceof FakeDownload) {
            return $download->getSource();
        }

        return null;
    }
}
