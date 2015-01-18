<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Extension\Extension;
use Fake\Extension\FakeExtension;
use Fake\Release\FakeRepository;

/**
 * Defines application features from the specific context.
 */
class ExtensionMaintainerContext implements Context, SnippetAcceptingContext
{
    use ReleaseTransformations;

    /**
     * Initializes context.
     */
    public function __construct()
    {
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
     * @When I release :arg1 version :arg2
     */
    public function iReleaseVersion($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then extension catalogue should contain :arg1 extension
     */
    public function extensionCatalogueShouldContainExtension($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then :arg1 extension should be in it
     */
    public function extensionShouldBeInIt($arg1)
    {
        throw new PendingException();
    }
}
