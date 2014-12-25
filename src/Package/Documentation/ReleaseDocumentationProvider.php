<?php

namespace Behat\Borg\Package\Documentation;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Provider\DocumentationProvider;
use Behat\Borg\Package\Downloader\DownloadedRelease;
use Behat\Borg\Package\Downloader\ReleaseDownloader;
use Behat\Borg\SphinxDoc\RstDocumentationSource;

/**
 * Documentation provider that works together with release downloader.
 */
final class ReleaseDocumentationProvider implements DocumentationProvider
{
    private $releaseDownloader;

    public function __construct(ReleaseDownloader $releaseDownloader)
    {
        $this->releaseDownloader = $releaseDownloader;
    }

    /**
     * {@inheritdoc}
     */
    public function findDocumentationById(DocumentationId $anId)
    {
        if (!$anId instanceof ReleaseDocumentationId) {
            throw new \InvalidArgumentException(
                'GitHubDocumentationProvider works only with ReleaseDocumentationId.'
            );
        }

        $downloadedRelease = $this->releaseDownloader->downloadRelease($anId->getRelease());

        return $this->createDocumentation($anId, $downloadedRelease);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllDocumentation()
    {
        $allDocumentation = [];
        foreach ($this->releaseDownloader->downloadAllReleases() as $downloadedRelease) {
            $anId = new ReleaseDocumentationId($downloadedRelease->getRelease());

            if ($documentation = $this->createDocumentation($anId, $downloadedRelease)) {
                $allDocumentation[] = $documentation;
            }
        }

        return $allDocumentation;
    }

    private function createDocumentation(DocumentationId $anId, DownloadedRelease $release)
    {
        if ($release->hasFile('doc/index.rst')) {
            $source = RstDocumentationSource::atPath($release->getPath() . '/doc');
        }

        if ($release->hasFile('index.rst')) {
            $source = RstDocumentationSource::atPath($release->getPath());
        }

        if (!isset($source)) {
            return null;
        }

        return new Documentation($anId, $source, $release->getReleaseTime());
    }
}
