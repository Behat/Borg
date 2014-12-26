<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\DocumentationManager;
use Behat\Borg\GitHub\GitHubPackage;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Github\Client;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Defines application features from the specific context.
 */
class DocumentationManagerCliContext implements Context, SnippetAcceptingContext
{
    private $manager;
    private $client;

    /**
     * Initializes context.
     *
     * @param DocumentationManager $manager
     * @param Client               $client
     */
    public function __construct(DocumentationManager $manager, Client $client)
    {
        $this->manager = $manager;
        $this->client = $client;
    }

    /**
     * @BeforeScenario
     */
    public function cleanBuildAndWebFolders()
    {
        (new Filesystem())->remove(
            [
                __DIR__ . '/../../build/repositories/behat',
                __DIR__ . '/../../build/docs/behat',
                __DIR__ . '/../../web/docs/behat'
            ]
        );
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
        $this->client->repo()->branches(
            (string)$package->getOrganisation(),
            (string)$package->getName(),
            (string)$version
        );
    }

    /**
     * @When I build the documentation
     */
    public function iBuildTheDocumentation()
    {
        $process = new Process(__DIR__ . '/../../app/console doc:build -e=test');
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException(
                sprintf("%s\n%s", $process->getOutput(), $process->getErrorOutput())
            );
        }
    }

    /**
     * @Then the documentation for :package version :version should have been published
     */
    public function theDocumentationShouldHaveBeenBuilt(Package $package, Version $version)
    {
        $id = new ReleaseDocumentationId(new Release($package, $version));
        $publishedDocumentation = $this->manager->getPublishedDocumentation($id);

        PHPUnit_Framework_Assert::assertNotNull(
            $publishedDocumentation, 'Documentation is not published.'
        );
    }
}
