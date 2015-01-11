<?php

namespace Behat\Borg\PackageDocumentation;

use Behat\Borg\Documentation\RawDocumentation;
use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Documenter;
use Behat\Borg\Package\Listener\PackageListener;
use Behat\Borg\Package\PackageDownload;

/**
 * Builds documentation after package was been downloaded.
 */
final class PackagedDocumentationBuilder implements PackageListener
{
    /**
     * @var SourceFinder
     */
    private $finder;
    /**
     * @var Documenter
     */
    private $manager;

    /**
     * Initializes listener.
     *
     * @param SourceFinder         $finder
     * @param Documenter $manager
     */
    public function __construct(SourceFinder $finder, Documenter $manager)
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
        $package = $packageDownload->getPackage();
        $download = $packageDownload->getDownload();

        if (null === $source = $this->finder->findSource($download)) {
            return;
        }

        $version = $download->getVersion();
        $time = $download->getReleaseTime();
        $anId = new PackagedDocumentationId($package, $version);

        $this->manager->process(new RawDocumentation($anId, $time, $source));
    }
}
