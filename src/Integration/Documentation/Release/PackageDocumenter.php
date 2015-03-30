<?php

namespace Behat\Borg\Integration\Documentation\Release;

use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Documentation\RawDocumentation;
use Behat\Borg\Documentation\Source;
use Behat\Borg\Documenter;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Downloader\DownloadedPackage;
use Behat\Borg\Release\Listener\PackageListener;
use Behat\Borg\Release\Package;

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
     * @var DocumentationIdFactory
     */
    private $idFactory;
    /**
     * @var Documenter
     */
    private $documenter;

    /**
     * Initializes listener.
     *
     * @param SourceFinder           $finder
     * @param DocumentationIdFactory $idFactory
     * @param Documenter             $documenter
     */
    public function __construct(SourceFinder $finder, DocumentationIdFactory $idFactory, Documenter $documenter)
    {
        $this->finder = $finder;
        $this->idFactory = $idFactory;
        $this->documenter = $documenter;
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

        $rawDocumentation = $this->rawDocumentation($download, $package, $source);
        $this->documenter->process($rawDocumentation);
    }

    /**
     * Gets raw documentation from the provided download, package and source.
     *
     * @param Download $download
     * @param Package  $package
     * @param Source   $source
     *
     * @return RawDocumentation
     */
    private function rawDocumentation(Download $download, Package $package, Source $source)
    {
        $version = $download->version();
        $time = $download->releasedAt();
        $anId = $this->idFactory->createDocumentationId($package, $version);

        return new RawDocumentation($anId, $time, $source);
    }
}
