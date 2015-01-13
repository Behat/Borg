<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\GitHub\GitHubRepository;
use Behat\Borg\Package\Package;
use Behat\Borg\Release\Repository;
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
     * @Transform :repository
     */
    public function transformStringToRepository($string)
    {
        return GitHubRepository::named($string);
    }

    /**
     * @Given :package version :version was documented in :repository
     */
    public function packageWasDocumented(Package $package, Version $version, Repository $repository)
    {
        PHPUnit::assertTrue(
            $this->repositoryPackageIs($repository, $version, $package),
            "Repository `{$repository}` {$version} package name is not `{$package}`."
        );

        PHPUnit::assertTrue(
            $this->repositoryContainsDocs($repository, $version),
            'Documentation is not found in the provided repository version.'
        );
    }

    /**
     * @Given :package version :version was documented in :repository on :time
     */
    public function packageWasDocumentedOn(Package $package, Version $version, Repository $repository, DateTimeImmutable $time)
    {
        $this->packageWasDocumented($package, $version, $repository);

        PHPUnit::assertEquals($time, $this->getLatestCommitDate($repository, $version));
    }

    /**
     * @Given :package version :version was not documented
     */
    public function packageWasNotDocumented()
    {
    }

    /**
     * @When I release :repository version :version
     */
    public function iReleaseRelease(Repository $repository, Version $version)
    {
        $process = new Process($this->releaseCommand($repository, $version));
        $process->run();

        PHPUnit::assertTrue($process->isSuccessful(), "{$process->getOutput()}\n{$process->getErrorOutput()}");
    }

    /**
     * @Then :project version :versionString documentation should have been published
     */
    public function packageDocumentationShouldHaveBeenPublished($project, $versionString)
    {
        $this->visitPath("/docs/$project/$versionString/index.html");

        $this->assertSession()->pageTextContains($project);
        $this->assertSession()->pageTextContains($versionString);
    }

    /**
     * @Then :project version :versionString documentation should not be published
     */
    public function packageDocumentationShouldNotBePublished($project, $versionString)
    {
        $this->visitPath("/docs/$project/$versionString/index.html");

        $this->assertSession()->statusCodeEquals(404);
    }

    /**
     * @Then current version of :project documentation should point to version :versionString
     */
    public function currentVersionOfDocumentationShouldPointToVersion($project, $versionString)
    {
        $this->visitPath("/docs/$project/current/index.html");

        $this->assertSession()->elementTextContains('css', '.version.current', $versionString);
    }

    private function releaseCommand(Repository $repository, Version $version)
    {
        return __DIR__ . "/../../app/console release {$repository} {$version} -e=test";
    }

    private function repositoryContainsDocs(Repository $repository, Version $version)
    {
        return $this->existsInRepositoryVersion($repository, $version, 'index.rst')
            || $this->existsInRepositoryVersion($repository, $version, 'doc/index.rst');
    }

    private function repositoryPackageIs(Repository $repository, Version $version, Package $package)
    {
        if ($this->existsInRepositoryVersion($repository, $version, 'borg.json')) {
            $content = $this->contentInRepositoryVersion($repository, $version, 'borg.json');

            return 1 === preg_match('#"for-package":\s*"' . preg_quote((string)$package) . '"#', $content);
        }

        if ($this->existsInRepositoryVersion($repository, $version, 'composer.json')) {
            $content = $this->contentInRepositoryVersion($repository, $version, 'composer.json');

            return 1 === preg_match('#"name":\s*"' . preg_quote((string)$package) . '"#', $content);
        }

        return false;
    }

    private function existsInRepositoryVersion(Repository $repository, Version $version, $path)
    {
        return $this->client->repo()->contents()->exists(
            (string)$repository->getOrganisationName(), (string)$repository->getName(), $path, (string)$version
        );
    }

    private function contentInRepositoryVersion(Repository $repository, Version $version, $path)
    {
        return file_get_contents($this->client->repo()->contents()->show(
            (string)$repository->getOrganisationName(), (string)$repository->getName(), $path, (string)$version
        )['download_url']);
    }

    private function getLatestCommitDate(Repository $package, Version $version)
    {
        $commit = $this->client->repo()->commits()->all(
            $package->getOrganisationName(), $package->getName(), ['sha' => (string)$version]
        );

        return new \DateTimeImmutable($commit[0]['commit']['author']['date']);
    }
}
