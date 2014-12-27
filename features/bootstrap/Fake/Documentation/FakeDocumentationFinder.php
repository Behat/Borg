<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\Finder\DocumentationFinder;
use Behat\Borg\Package\Downloader\DownloadedRelease;
use Behat\Borg\Package\Release;

final class FakeDocumentationFinder implements DocumentationFinder
{
    private $documentation = [];

    public function releaseWasDocumented(Release $release, Documentation $documentation)
    {
        $this->documentation[(string)$release] = $documentation;
    }

    public function findDocumentation(DownloadedRelease $downloadedRelease)
    {
        return $this->documentation[(string)$downloadedRelease->getRelease()];
    }
}
