<?php

namespace Behat\Borg\Documentation\Listener;

use Behat\Borg\Documentation\Builder\DocumentationBuilder;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\Finder\DocumentationSourceFinder;
use Behat\Borg\Package\Downloader\DownloadedRelease;
use Behat\Borg\Package\Listener\ReleaseDownloadListener;

/**
 * Builds documentation after release was been downloaded.
 */
final class DocumentingDownloadListener implements ReleaseDownloadListener
{
    /**
     * @var DocumentationSourceFinder
     */
    private $finder;
    /**
     * @var DocumentationBuilder
     */
    private $builder;
    /**
     * @var DocumentationBuildListener[]
     */
    private $listeners;

    /**
     * Initializes listener.
     *
     * @param DocumentationSourceFinder $finder
     * @param DocumentationBuilder      $builder
     */
    public function __construct(DocumentationSourceFinder $finder, DocumentationBuilder $builder)
    {
        $this->finder = $finder;
        $this->builder = $builder;
    }

    /**
     * Registers build listener.
     *
     * @param DocumentationBuildListener $listener
     */
    public function registerListener(DocumentationBuildListener $listener)
    {
        $this->listeners[] = $listener;
    }

    /**
     * {@inheritdoc}
     */
    public function releaseWasDownloaded(DownloadedRelease $download)
    {
        if (null === $source = $this->finder->findDocumentationSource($download)) {
            return;
        }

        $documentation = Documentation::downloaded($download, $source);
        $builtDocumentation = $this->builder->buildDocumentation($documentation);

        foreach ($this->listeners as $listener) {
            $listener->documentationWasBuilt($builtDocumentation);
        }
    }
}
