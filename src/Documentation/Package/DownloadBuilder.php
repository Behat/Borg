<?php

namespace Behat\Borg\Documentation\Package;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\DocumentationManager;
use Behat\Borg\Documentation\Package\ReleaseDocumentationId;
use Behat\Borg\Package\Downloader\Download;
use Behat\Borg\Package\Listener\DownloadListener;

/**
 * Builds documentation after release was been downloaded.
 */
final class DownloadBuilder implements DownloadListener
{
    /**
     * @var SourceFinder
     */
    private $finder;
    /**
     * @var DocumentationManager
     */
    private $manager;

    /**
     * Initializes listener.
     *
     * @param SourceFinder         $finder
     * @param DocumentationManager $manager
     */
    public function __construct(SourceFinder $finder, DocumentationManager $manager)
    {
        $this->finder = $finder;
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function releaseWasDownloaded(Download $download)
    {
        if (null === $source = $this->finder->findSource($download)) {
            return;
        }

        $anId = new ReleaseDocumentationId($download->getRelease());
        $time = $download->getReleaseTime();

        $this->manager->build(new Documentation($anId, $time, $source));
    }
}
