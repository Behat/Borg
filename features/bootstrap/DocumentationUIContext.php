<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\GitHub\GitHubRepository;
use Behat\Borg\PackageDocumentation\ReleaseDocumentationId;
use Behat\Borg\Release\Repository;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\Version;
use Behat\MinkExtension\Context\RawMinkContext;
use Github\Client;
use PHPUnit_Framework_Assert as PHPUnit;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Defines application features from the specific context.
 */
class DocumentationUIContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
    private $publisher;
    private $client;

    use DocumentationTransformations;

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
        $cacheDir = __DIR__ . '/../../app/cache/test';
        (new Filesystem())->remove([ "{$cacheDir}/build", "{$cacheDir}/docs" ]);
    }

    /**
     * @Transform :package
     */
    public function transformStringToPackage($string)
    {
        return GitHubRepository::named($string);
    }

    /**
     * @Given :package version :version was documented in :repository
     */
    public function releaseWasDocumented($package, Version $version, Repository $repository)
    {
        $rstIsInRepo = $this->fileExistsInRepositoryVersion($repository, $version, 'index.rst')
                    || $this->fileExistsInRepositoryVersion($repository, $version, 'doc/index.rst');

        PHPUnit::assertTrue($rstIsInRepo, 'RST is not found in the provided repository version');
    }

    /**
     * @Given :package version :version was documented in :repository on :time
     */
    public function releaseWasDocumentedOn($package, Version $version, Repository $repository, DateTimeImmutable $time)
    {
        $this->releaseWasDocumented($package, $repository, $version);

        PHPUnit::assertEquals($time, $this->getLatestCommitDate($repository, $version));
    }

    /**
     * @Given :package version :version was not documented
     */
    public function releaseWasNotDocumented(Repository $package, Version $version)
    {
        $rstIsInRepo = $this->fileExistsInRepositoryVersion($package, $version, 'index.rst')
                    || $this->fileExistsInRepositoryVersion($package, $version, 'doc/index.rst');

        PHPUnit::assertFalse($rstIsInRepo, 'RST is found in the provided repository version');
    }

    /**
     * @When I release :package version :version
     */
    public function iReleaseRelease(Repository $package, Version $version)
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
    public function releaseDocumentationShouldHaveBeenPublished(Repository $package, Version $version)
    {
        $anId = new ReleaseDocumentationId(new Release($package, $version));
        $this->visitPath('/docs/' . $anId . '/index.html');

        $this->assertSession()->pageTextContains($package);
        $this->assertSession()->pageTextContains($version);
    }

    /**
     * @Then :package version :version documentation should not be published
     */
    public function releaseDocumentationShouldNotBePublished(Repository $package, Version $version)
    {
        $anId = new ReleaseDocumentationId(new Release($package, $version));
        $this->visitPath('/docs/' . $anId . '/index.html');

        $this->assertSession()->statusCodeEquals(404);
    }

    private function packageReleaseCommand(Repository $package, Version $version)
    {
        return __DIR__ . "/../../app/console release {$package} {$version} -e=test";
    }

    private function fileExistsInRepositoryVersion(Repository $package, Version $version, $path)
    {
        return $this->client->repo()->contents()->exists(
            (string)$package->getOrganisation(), (string)$package->getName(), $path, (string)$version
        );
    }

    private function getLatestCommitDate(Repository $package, Version $version)
    {
        $commit = $this->client->repo()->commits()->all(
            $package->getOrganisation(), $package->getName(), ['sha' => (string)$version]
        );

        return new \DateTimeImmutable($commit[0]['commit']['author']['date']);
    }
}
