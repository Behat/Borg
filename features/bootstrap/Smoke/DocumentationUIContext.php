<?php

namespace Smoke;

use Behat\Behat\Context\Context;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\MinkExtension\Context\RawMinkContext;
use DateTimeImmutable;
use Github\Client;
use PHPUnit_Framework_Assert as PHPUnit;
use Transformation;

/**
 * Defines application features from the specific context.
 */
class DocumentationUIContext extends RawMinkContext implements Context
{
    use Transformation\CleanBuildCache;

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
     * @Given :package version :version was documented in :repository
     */
    public function packageWasDocumented($package, $version, $repository)
    {
        PHPUnit::assertTrue($this->repositoryPackageIs($repository, $version, $package),
            "Repository `{$repository}` {$version} package name is not `{$package}`."
        );

        PHPUnit::assertTrue($this->repositoryContainsDocs($repository, $version),
            'Documentation is not found in the provided repository version.'
        );
    }

    /**
     * @Given :package version :version was documented in :repository on :time
     */
    public function packageWasDocumentedOn($package, $version, $repository, $time)
    {
        $this->packageWasDocumented($package, $version, $repository);

        PHPUnit::assertEquals($time, $this->lastCommitTime($repository, $version));
    }

    /**
     * @Given :package version :version was not documented
     */
    public function packageWasNotDocumented() { }

    /**
     * @Then :project version :versionString documentation should have been published
     */
    public function packageDocumentationShouldHaveBeenPublished($project, $versionString)
    {
        $this->visitPath($this->documentationPagePath($project, $versionString, 'index.html'));

        $this->assertSession()->pageTextContains($project);
        $this->assertSession()->pageTextContains($versionString);
    }

    /**
     * @Then :project version :versionString documentation should not be published
     */
    public function packageDocumentationShouldNotBePublished($project, $versionString)
    {
        $this->visitPath($this->documentationPagePath($project, $versionString, 'index.html'));

        $this->assertSession()->statusCodeEquals(404);
    }

    /**
     * @Then current version of :project documentation should point to version :versionString
     */
    public function currentVersionOfDocumentationShouldPointToVersion($project, $versionString)
    {
        $this->visitPath($this->documentationPagePath($project, $versionString, 'index.html'));

        $this->assertSession()->elementTextContains('css', '.version.current', $versionString);
    }

    private function documentationPagePath($project, $versionString, $page)
    {
        return "/docs/$project/$versionString/$page";
    }

    private function repositoryContainsDocs($repository, $version)
    {
        return $this->existsInRepositoryVersion($repository, $version, 'index.rst')
            || $this->existsInRepositoryVersion($repository, $version, 'doc/index.rst');
    }

    private function repositoryPackageIs($repository, $version, $package)
    {
        if ($this->existsInRepositoryVersion($repository, $version, 'borg.json')) {
            $content = $this->contentInRepositoryVersion($repository, $version, 'borg.json');

            return 1 === preg_match('#"for-package":\s*"' . preg_quote($package) . '"#', $content);
        }

        if ($this->existsInRepositoryVersion($repository, $version, 'composer.json')) {
            $content = $this->contentInRepositoryVersion($repository, $version, 'composer.json');

            return 1 === preg_match('#"name":\s*"' . preg_quote($package) . '"#', $content);
        }

        return false;
    }

    private function existsInRepositoryVersion($repository, $version, $path)
    {
        $repositoryParts = explode('/', $repository);

        return $this->client->repo()->contents()->exists($repositoryParts[0], $repositoryParts[1], $path, $version);
    }

    private function contentInRepositoryVersion($repository, $version, $path)
    {
        $repositoryParts = explode('/', $repository);

        return file_get_contents($this->client->repo()->contents()->show($repositoryParts[0], $repositoryParts[1], $path, $version)['download_url']);
    }

    private function lastCommitTime($package, $version)
    {
        $packageParts = explode('/', $package);

        $commit = $this->client->repo()->commits()->all($packageParts[0], $packageParts[1], ['sha' => $version]);

        return (new \DateTimeImmutable($commit[0]['commit']['author']['date']))->format('d.m.Y, H:i:s');
    }
}
