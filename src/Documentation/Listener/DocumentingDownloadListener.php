<?php

namespace Behat\Borg\Documentation\Listener;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Package\Downloader\Download;
use Behat\Borg\Package\Listener\ReleaseDownloadListener;

/**
 * Builds documentation after release was been downloaded.
 */
final class DocumentingDownloadListener implements ReleaseDownloadListener
{
    /**
     * @var SourceFinder
     */
    private $finder;
    /**
     * @var Builder
     */
    private $builder;
    /**
     * @var DocumentationBuildListener[]
     */
    private $listeners;

    /**
     * Initializes listener.
     *
     * @param SourceFinder $finder
     * @param Builder      $builder
     */
    public function __construct(SourceFinder $finder, Builder $builder)
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
    public function releaseWasDownloaded(Download $download)
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