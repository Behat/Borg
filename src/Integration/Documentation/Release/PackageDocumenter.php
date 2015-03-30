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
