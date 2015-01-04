<?php

namespace Behat\Borg\PackageDocumentation;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\DocumentationManager;
use Behat\Borg\Package\Listener\PackageListener;
use Behat\Borg\Package\PackageDownload;

/**
 * Builds documentation after package was been downloaded.
 */
final class PackageDocumentationBuilder implements PackageListener
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
     * Notifies listeners that package was downloaded.
     *
     * @param PackageDownload $packageDownload
     */
    public function packageWasDownloaded(PackageDownload $packageDownload)
    {
        if (null === $source = $this->finder->findSource($packageDownload->getDownload())) {
            return;
        }

        $package = $packageDownload->getPackage();
        $version = $packageDownload->getVersion();
        $time = $packageDownload->getReleaseTime();
        $anId = new PackageDocumentationId($package, $version);

        $this->manager->build(new Documentation($anId, $time, $source));
    }
}
