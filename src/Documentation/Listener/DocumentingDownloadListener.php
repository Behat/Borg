<?php

namespace Behat\Borg\Documentation\Listener;

use Behat\Borg\Documentation\Builder\DocumentationBuilder;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\Finder\DocumentationSourceFinder;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Downloader\DownloadedRelease;
use Behat\Borg\Package\Listener\ReleaseDownloadListener;

final class DocumentingDownloadListener implements ReleaseDownloadListener
{
    private $finder;
    private $builder;
    private $listeners;

    public function __construct(DocumentationSourceFinder $finder, DocumentationBuilder $builder)
    {
        $this->finder = $finder;
        $this->builder = $builder;
    }

    public function registerListener(DocumentationBuildListener $listener)
    {
        $this->listeners[] = $listener;
    }

    public function releaseWasDownloaded(DownloadedRelease $downloadedRelease)
    {
        if (!$source = $this->finder->findDocumentationSource($downloadedRelease)) {
            return;
        }

        $anId = new ReleaseDocumentationId($downloadedRelease->getRelease());
        $documentation = new Documentation($anId, $source, $downloadedRelease->getReleaseTime());

        $builtDocumentation = $this->builder->build($documentation);

        foreach ($this->listeners as $listener) {
            $listener->documentationWasBuilt($builtDocumentation);
        }
    }
}
