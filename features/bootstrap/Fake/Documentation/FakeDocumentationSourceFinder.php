<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\Documentation\Finder\DocumentationSourceFinder;
use Behat\Borg\Package\Downloader\Download;
use Behat\Borg\Package\Release;

final class FakeDocumentationSourceFinder implements DocumentationSourceFinder
{
    private $source = [];

    public function releaseWasDocumented(Release $release, DocumentationSource $source)
    {
        $this->source[(string)$release] = $source;
    }

    public function findDocumentationSource(Download $download)
    {
        return $this->source[(string)$download->getRelease()];
    }
}
