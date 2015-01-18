<?php

namespace Behat\Borg\PackageDocumentation;

use Behat\Borg\Documentation\RawDocumentation;
use Behat\Borg\Documentation\Finder\SourceFinder;
use Behat\Borg\Documenter;
use Behat\Borg\Package\Listener\PackageListener;
use Behat\Borg\Package\PackageDownload;

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
     * Initializes listener.
     *
     * @param SourceFinder $finder
     * @param Documenter   $documenter
     */
    public function __construct(SourceFinder $finder, Documenter $documenter)
    {
        $this->finder = $finder;
        $this->documenter = $documenter;
    }

    /**
     * Notifies listeners that package was downloaded.
     *
     * @param PackageDownload $packageDownload
     */
    public function packageWasDownloaded(PackageDownload $packageDownload)
    {
        $package = $packageDownload->package();
        $download = $packageDownload->download();

        if (null === $source = $this->finder->find($download)) {
            return;
        }

        $version = $download->version();
        $time = $download->releasedAt();
        $anId = new PackagedDocumentationId($package, $version);

        $this->documenter->process(new RawDocumentation($anId, $time, $source));
    }
}
