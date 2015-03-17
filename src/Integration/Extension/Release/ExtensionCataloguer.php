<?php

namespace Behat\Borg\Integration\Extension\Release;

use Behat\Borg\Extension\Extractor\Extractor;
use Behat\Borg\ExtensionCatalogue;
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
     * @var ExtensionCatalogue
     */
    private $catalogue;

    /**
     * Initializes cataloguer.
     *
     * @param Extractor          $extractor
     * @param ExtensionCatalogue $catalogue
     */
    public function __construct(Extractor $extractor, ExtensionCatalogue $catalogue)
    {
        $this->extractor = $extractor;
        $this->catalogue = $catalogue;
    }

    /**
     * {@inheritdoc}
     */
    public function packageDownloaded(DownloadedPackage $downloadedPackage)
    {
        if (null === $extension = $this->extractor->extract($downloadedPackage->package())) {
            return;
        }

        $this->catalogue->register($extension);
    }
}
