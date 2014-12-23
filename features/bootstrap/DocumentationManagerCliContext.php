<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\DocumentationProvider;
use Behat\Borg\GitHub\GitHubPackage;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;

/**
 * Defines application features from the specific context.
 */
class DocumentationManagerCliContext implements Context, SnippetAcceptingContext
{
    private $provider;

    /**
     * Initializes context.
     */
    public function __construct(DocumentationProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @Transform :package
     */
    public function transformStringToPackage($string)
    {
        return GithubPackage::named($string);
    }

    /**
     * @Transform :version
     */
    public function transformStringToVersion($string)
    {
        return Version::string($string);
    }

    /**
     * @Given :package version :version was documented
     */
    public function versionWasDocumented(Package $package, Version $version)
    {
        $anId = new ReleaseDocumentationId(new Release($package, $version));

        PHPUnit_Framework_Assert::assertNotNull(
            $this->provider->findDocumentationById($anId),
            'Provider does not know about the expected documentation.'
        );
    }

    /**
     * @When I build the documentation
     */
    public function iBuildTheDocumentation()
    {
        throw new PendingException();
    }

    /**
     * @Then the documentation for :arg1 version :arg2 should have been built
     */
    public function theDocumentationForVersionShouldHaveBeenBuilt($arg1, $arg2)
    {
        throw new PendingException();
    }
}
