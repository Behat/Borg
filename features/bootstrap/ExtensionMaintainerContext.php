<?php

use Behat\Behat\Context\Context;
use Behat\Borg\ExtensionCatalogue;
use Behat\Borg\Integration\Extension\Filesystem\PersistedObjectsRepository;
use Behat\Borg\Integration\Extension\Release\ExtensionCataloguer;
use Behat\Borg\Release\Package;
use Behat\Borg\Release\ReleaseDownloader;
use Behat\Borg\Release\ReleasePackager;
use Behat\Borg\Release\Version;
use Behat\Borg\ReleaseManager;
use Fake\Extension\FakeExtensionPackage;
use Fake\Extension\FakeExtractor;
use Fake\Release\FakeDownloader;
use Fake\Release\FakePackageFinder;
use Fake\Release\FakeRepository;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Defines application features from the specific context.
 */
class ExtensionMaintainerContext implements Context
{
    use Transformation\Release;
    use Transformation\Extension;
    use Transformation\Documentation;

    private $releaseManager;
    private $catalogue;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $repository = new PersistedObjectsRepository(null);
        $this->releaseManager = new ReleaseManager();
        $this->catalogue = new ExtensionCatalogue($repository);

        $releaseDownloader = new ReleaseDownloader(new FakeDownloader());
        $releasePackager = new ReleasePackager(new FakePackageFinder());
        $extensionCataloguer = new ExtensionCataloguer(new FakeExtractor(), $repository);

        $this->releaseManager->registerListener($releaseDownloader);
        $releaseDownloader->registerListener($releasePackager);
        $releasePackager->registerListener($extensionCataloguer);
    }

    /**
     * @Given :extensionPackage extension package was created in :repository
     */
    public function extensionPackageWasCreated(FakeRepository $repository, FakeExtensionPackage $extensionPackage)
    {
        $repository->createPackage($extensionPackage);
    }

    /**
     * @Given extension package was not created in :repository
     */
    public function extensionPackageWasNotCreated() { }

    /**
     * @Given :package version :version was documented in :repository
     */
    public function packageWasDocumented(FakeRepository $repository, Package $package, Version $version)
    {
        $repository->documentPackage($package, $version, new DateTimeImmutable());
    }

    /**
     * @When I release :repository version :version
     */
    public function iReleaseVersion(FakeRepository $repository, Version $version)
    {
        $this->releaseManager->release($repository, $version);
    }

    /**
     * @Then the extension catalogue should contain :count extension(s)
     * @Then the extension catalogue should still contain :count extension(s)
     * @Then the extension catalogue should be empty
     */
    public function extensionCatalogueShouldHaveCount($count = 0)
    {
        PHPUnit::assertCount($count, $this->catalogue->all());
    }

    /**
     * @Then :extensionName extension should be in the catalogue
     */
    public function extensionShouldBeInCatalogue($extensionName)
    {
        $this->catalogue->extension($extensionName);
    }
}
