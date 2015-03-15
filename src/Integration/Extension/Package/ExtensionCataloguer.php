<?php

namespace Behat\Borg\Integration\Extension\Package;

use Behat\Borg\Extension\Extractor\Extractor;
use Behat\Borg\ExtensionCatalogue;
use Behat\Borg\Package\Listener\PackageListener;
use Behat\Borg\Package\DownloadedPackage;

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
    public function packageWasDownloaded(DownloadedPackage $downloadedPackage)
    {
        if (null === $extension = $this->extractor->extract($downloadedPackage->package())) {
            return;
        }

        $this->catalogue->register($extension);
    }
}
