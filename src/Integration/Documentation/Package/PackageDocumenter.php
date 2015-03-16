<?php

namespace Behat\Borg\Integration\Documentation\Package;

use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Documentation\RawDocumentation;
use Behat\Borg\Documenter;
use Behat\Borg\Release\Downloader\DownloadedPackage;
use Behat\Borg\Release\Listener\PackageListener;

/**
 * Processes packaged documentation.
 */
final class PackageDocumenter implements PackageListener
{
    /**
     * @var SourceFinder
     */
    private $finder;
    /**
     * @var Documenter
     */
    private $documenter;
    /**
     * @var DocumentationIdFactory
     */
    private $idFactory;

    /**
     * Initializes listener.
     *
     * @param SourceFinder           $finder
     * @param Documenter             $documenter
     * @param DocumentationIdFactory $idFactory
     */
    public function __construct(SourceFinder $finder, Documenter $documenter, DocumentationIdFactory $idFactory)
    {
        $this->finder = $finder;
        $this->documenter = $documenter;
        $this->idFactory = $idFactory;
    }

    /**
     * Notifies listeners that package was downloaded.
     *
     * @param DownloadedPackage $downloadedPackage
     */
    public function packageDownloaded(DownloadedPackage $downloadedPackage)
    {
        $package = $downloadedPackage->package();
        $download = $downloadedPackage->download();

        if (null === $source = $this->finder->find($download)) {
            return;
        }

        $version = $download->version();
        $time = $download->releasedAt();
        $anId = $this->idFactory->createDocumentationId($package, $version);

        $this->documenter->process(new RawDocumentation($anId, $time, $source));
    }
}
