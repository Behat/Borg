<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\GitHub\GitHubPackage;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Github\Client;
use PHPUnit_Framework_Assert as PHPUnit;
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
     * @param Publisher $publisher
     * @param Client    $client
     */
    public function __construct(Publisher $publisher, Client $client)
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
    public function releaseWasDocumented(Package $package, Version $version)
    {
        $rstIsInRepo = $this->fileExistsInRepositoryVersion($package, $version, 'index.rst')
                    || $this->fileExistsInRepositoryVersion($package, $version, 'doc/index.rst');

        PHPUnit::assertTrue($rstIsInRepo, 'RST is not found in the provided repository version');
    }

    /**
     * @When I release :package version :version
     */
    public function iReleaseRelease(Package $package, Version $version)
    {
        $process = new Process($this->packageReleaseCommand($package, $version));
        $process->run();

        PHPUnit::assertTrue(
            $process->isSuccessful(), "{$process->getOutput()}\n{$process->getErrorOutput()}"
        );
    }

    /**
     * @Then :package version :version documentation should have been published
     */
    public function releaseDocumentationShouldHaveBeenPublished(Package $package, Version $version)
    {
        PHPUnit::assertTrue(
            $this->publisher->hasPublishedDocumentation(
                new ReleaseDocumentationId(new Release($package, $version))
            )
        );
    }

    private function packageReleaseCommand(Package $package, Version $version)
    {
        return __DIR__ . "/../../app/console package:released {$package} {$version} -e=test";
    }

    private function fileExistsInRepositoryVersion(Package $package, Version $version, $path)
    {
        return $this->client->repo()->contents()->exists(
            (string)$package->getOrganisation(), (string)$package->getName(), $path, (string)$version
        );
    }
}
