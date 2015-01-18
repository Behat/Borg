<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Application\Infrastructure\Extension\PersistedObjectsRepository;
use Behat\Borg\Extension\Extension;
use Behat\Borg\ExtensionCatalogue;
use Behat\Borg\ExtensionPackage\ExtensionCataloguer;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\ReleasePackager;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\ReleaseDownloader;
use Behat\Borg\Release\Version;
use Behat\Borg\ReleaseManager;
use Fake\Extension\FakeExtension;
use Fake\Extension\FakeExtractor;
use Fake\Package\FakePackageFinder;
use Fake\Release\FakeDownloader;
use Fake\Release\FakeRepository;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Defines application features from the specific context.
 */
class ExtensionMaintainerContext implements Context, SnippetAcceptingContext
{
    use ContextHelper\DocumentationTransformations;
    use ContextHelper\ReleaseTransformations;

    private $releaseManager;
    private $catalogue;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $this->releaseManager = new ReleaseManager();
        $this->catalogue = new ExtensionCatalogue(new PersistedObjectsRepository(null));

        $releaseDownloader = new ReleaseDownloader(new FakeDownloader());
        $releasePackager = new ReleasePackager(new FakePackageFinder());
        $extensionCataloguer = new ExtensionCataloguer(new FakeExtractor(), $this->catalogue);

        $this->releaseManager->registerListener($releaseDownloader);
        $releaseDownloader->registerListener($releasePackager);
        $releasePackager->registerListener($extensionCataloguer);
    }

    /**
     * @Transform :extension
     */
    public function transformStringToExtension($string)
    {
        return FakeExtension::named($string);
    }

    /**
     * @Transform :count
     */
    public function transformStringToCount($string)
    {
        return (int)$string;
    }

    /**
     * @Given :extension extension was created in :repository
     */
    public function extensionWasCreatedIn(Extension $extension, FakeRepository $repository)
    {
        $repository->createExtension($extension);
    }

    /**
     * @Given extension was not created in :repository
     */
    public function extensionWasNotCreated()
    {
    }

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
        $this->releaseManager->release(new Release($repository, $version));
    }

    /**
     * @Then the extension catalogue should contain :count extension(s)
     * @Then the extension catalogue should still contain :count extension(s)
     * @Then the extension catalogue should be empty
     */
    public function extensionCatalogueShouldContainExtension($count = 0)
    {
        PHPUnit::assertCount($count, $this->catalogue->getAll());
    }

    /**
     * @Then :extensionName extension should be in the catalogue
     */
    public function extensionShouldBeInIt($extensionName)
    {
        PHPUnit::assertNotNull($this->catalogue->find($extensionName), 'Extension not found.');
    }
}
