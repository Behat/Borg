<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Extension\Extension;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\Version;
use Behat\Borg\ReleaseManager;
use Fake\Extension\FakeExtension;
use Fake\Release\FakeRepository;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Defines application features from the specific context.
 */
class ExtensionMaintainerContext implements Context, SnippetAcceptingContext
{
    use ContextHelper\ReleaseTransformations;

    private $releaseManager;
    private $extensionCatalogue;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $this->releaseManager = new ReleaseManager();
        $this->extensionCatalogue = new ExtensionCatalogue();
    }

    /**
     * @Transform :extension
     */
    public function transformStringToExtension($string)
    {
        return FakeExtension::named($string);
    }

    /**
     * @Given :extension extension was created in :repository
     */
    public function extensionWasCreatedIn(Extension $extension, FakeRepository $repository)
    {
        $repository->createExtension($extension);
    }

    /**
     * @When I release :repository version :version
     */
    public function iReleaseVersion(FakeRepository $repository, Version $version)
    {
        $this->releaseManager->release(new Release($repository, $version));
    }

    /**
     * @Then extension catalogue should contain :extensionName extension
     */
    public function extensionCatalogueShouldContainExtension($extensionName)
    {
        PHPUnit::assertNotNull($this->extensionCatalogue->find($extensionName));
    }

    /**
     * @Then :arg1 extension should be in it
     */
    public function extensionShouldBeInIt($arg1)
    {
        throw new PendingException();
    }
}
