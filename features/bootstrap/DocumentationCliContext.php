<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Publisher\DocumentationPublisher;
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
class DocumentationCliContext implements Context, SnippetAcceptingContext
{
    private $publisher;
    private $client;

    /**
     * Initializes context.
     *
     * @param DocumentationPublisher $publisher
     * @param Client                 $client
     */
    public function __construct(DocumentationPublisher $publisher, Client $client)
    {
        $this->publisher = $publisher;
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
    public function packageWasDocumented(Package $package, Version $version)
    {
        $this->client->repo()->branches(
            (string)$package->getOrganisation(),
            (string)$package->getName(),
            (string)$version
        );
    }

    /**
     * @When I release :package version :version
     */
    public function iReleasePackage(Package $package, Version $version)
    {
        $process = new Process(
            __DIR__ . "/../../app/console package:released {$package} {$version} -e=test"
        );
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
    public function thePackageDocumentationShouldHaveBeenBuilt(Package $package, Version $version)
    {
        $anId = new ReleaseDocumentationId(new Release($package, $version));
        PHPUnit_Framework_Assert::assertTrue($this->publisher->hasPublishedDocumentation($anId));
    }
}
