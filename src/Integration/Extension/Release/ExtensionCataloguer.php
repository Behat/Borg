<?php

namespace Behat\Borg\Integration\Extension\Release;

use Behat\Borg\Extension\Extractor\Extractor;
use Behat\Borg\Extension\Repository\Repository;
use Behat\Borg\Release\Downloader\DownloadedPackage;
use Behat\Borg\Release\Listener\PackageListener;

/**
 * Catalogues extension package.
 */
final class ExtensionCataloguer implements PackageListener
{
    /**
     * @var Extractor
     */
    private $extractor;
    /**
     * @var Repository
     */
    private $repository;

    /**
     * Initializes cataloguer.
     *
     * @param Extractor  $extractor
     * @param Repository $repository
     */
    public function __construct(Extractor $extractor, Repository $repository)
    {
        $this->extractor = $extractor;
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function packageDownloaded(DownloadedPackage $downloadedPackage)
    {
        if (null === $extension = $this->extractor->extract($downloadedPackage->package())) {
            return;
        }

        $this->repository->add($extension);
    }
}
