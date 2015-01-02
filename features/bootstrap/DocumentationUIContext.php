<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\GitHub\GitHubPackage;
use Behat\Borg\PackageDocumentation\ReleaseDocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
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
        return GithubPackage::named($string);
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
     * @Given :package version :version was documented on :time
     */
    public function releaseWasDocumentedOn(Package $package, Version $version, DateTimeImmutable $time)
    {
        $this->releaseWasDocumented($package, $version);

        PHPUnit::assertEquals($time, $this->getLatestCommitDate($package, $version));
    }

    /**
     * @Given :package version :version was not documented
     */
    public function releaseWasNotDocumented(Package $package, Version $version)
    {
        $rstIsInRepo = $this->fileExistsInRepositoryVersion($package, $version, 'index.rst')
                    || $this->fileExistsInRepositoryVersion($package, $version, 'doc/index.rst');

        PHPUnit::assertFalse($rstIsInRepo, 'RST is found in the provided repository version');
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
        $anId = new ReleaseDocumentationId(new Release($package, $version));
        $this->visitPath('/docs/' . $anId . '/index.html');

        $this->assertSession()->pageTextContains($package);
        $this->assertSession()->pageTextContains($version);
    }

    /**
     * @Then :package version :version documentation should not be published
     */
    public function releaseDocumentationShouldNotBePublished(Package $package, Version $version)
    {
        $anId = new ReleaseDocumentationId(new Release($package, $version));
        $this->visitPath('/docs/' . $anId . '/index.html');

        $this->assertSession()->statusCodeEquals(404);
    }

    /**
     * @Then package name of :pageId page for :package version :version should be :name
     */
    public function packageNameOfPageShouldBe(PageId $pageId, Package $package, Version $version, $name)
    {
        $anId = new ReleaseDocumentationId(new Release($package, $version));
        $this->visitPath('/docs/' . $anId . '/' . $pageId);

        $this->assertSession()->pageTextContains("Package name: {$name}");
    }

    /**
     * @Then documentation time of :arg1 page for :arg2 version :arg3 should be :arg4
     */
    public function documentationTimeOfPageForVersionShouldBe($arg1, $arg2, $arg3, $arg4)
    {
        throw new PendingException();
    }

    /**
     * @Then documentation for :arg1 should be in the list of available documentation for :arg2
     */
    public function documentationForShouldBeInTheListOfAvailableDocumentationFor($arg1, $arg2)
    {
        throw new PendingException();
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

    private function getLatestCommitDate(Package $package, Version $version)
    {
        $commit = $this->client->repo()->commits()->all(
            $package->getOrganisation(),
            $package->getName(),
            ['sha' => (string)$version]
        )[0];

        return new \DateTimeImmutable($commit['commit']['author']['date']);
    }
}
