<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\Documentation\Finder\DocumentationSourceFinder;
use Behat\Borg\Package\Downloader\DownloadedRelease;
use Behat\Borg\Package\Release;

final class FakeDocumentationSourceFinder implements DocumentationSourceFinder
{
    private $source = [];

    public function releaseWasDocumented(Release $release, DocumentationSource $source)
    {
        $this->source[(string)$release] = $source;
    }

    public function findDocumentationSource(DownloadedRelease $downloadedRelease)
    {
        return $this->source[(string)$downloadedRelease->getRelease()];
    }
}
