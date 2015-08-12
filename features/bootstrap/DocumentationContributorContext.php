<?php

use Behat\Behat\Context\Context;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Exception\PageNotFound;
use Behat\Borg\Documentation\Processor;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documenter;
use Behat\Borg\Integration\Documentation\Filesystem\PersistedObjectsRepository;
use Behat\Borg\Integration\Documentation\Release\DocumentationIdFactory;
use Behat\Borg\Integration\Documentation\Release\PackageDocumenter;
use Behat\Borg\Release\Package;
use Behat\Borg\Release\ReleaseDownloader;
use Behat\Borg\Release\ReleasePackager;
use Behat\Borg\Release\Version;
use Behat\Borg\ReleaseManager;
use Fake\Documentation\FakeBuilder;
use Fake\Documentation\FakePublisher;
use Fake\Documentation\FakeSourceFinder;
use Fake\Release\FakeDownloader;
use Fake\Release\FakePackageFinder;
use Fake\Release\FakeRepository;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Describes documentation-related features from the documentation manager context.
 */
class DocumentationContributorContext implements Context
{
    use Transformation\Release;
    use Transformation\Documentation;

    private $releaseManager;
    private $documenter;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $repository = new PersistedObjectsRepository(null);
        $this->documenter = new Documenter($repository);
        $this->releaseManager = new ReleaseManager();

        $releaseDownloader = new ReleaseDownloader(new FakeDownloader());
        $releasePackager = new ReleasePackager(new FakePackageFinder());
        $documentationProcessor = new Processor(new FakeBuilder(), new FakePublisher(), $repository);
        $packageDocumenter = new PackageDocumenter(new FakeSourceFinder(), new DocumentationIdFactory(), $documentationProcessor);

        $this->releaseManager->registerListener($releaseDownloader);
        $releaseDownloader->registerListener($releasePackager);
        $releasePackager->registerListener($packageDocumenter);
    }

    /**
     * @Given :package version :version was documented in :repository on :time
     */
    public function packageWasDocumentedOn(FakeRepository $repository, Package $package, Version $version, DateTimeImmutable $time)
    {
        $repository->documentPackage($package, $version, $time);
    }

    /**
     * @Given :package version :version was documented in :repository
     */
    public function packageWasDocumented(FakeRepository $repository, Package $package, Version $version)
    {
        $repository->documentPackage($package, $version, new DateTimeImmutable());
    }

    /**
     * @Given :package version :version was not documented
     */
    public function packageWasNotDocumented() { }

    /**
     * @When I release :repository version :version
     */
    public function iReleaseRelease(FakeRepository $repository, Version $version)
    {
        $this->releaseManager->release($repository, $version);
    }

    /**
     * @Then :project version :versionString documentation should have been published
     */
    public function releaseDocumentationShouldHaveBeenPublished($project, $versionString)
    {
        $this->documenter->documentationPage($project, $versionString, 'index.html');
    }

    /**
     * @Then :project version :versionString documentation should not be published
     */
    public function versionDocumentationShouldNotBePublished($project, $versionString)
    {
        try {
            $this->documenter->documentationPage($project, $versionString, 'index.html');
            PHPUnit_Framework_Assert::fail('Documentation was actually found.');
        } catch (PageNotFound $e) { /* Passes, do nothing */ }
    }

    /**
     * @Then project name of :pageString page for :project version :versionString should be :name
     */
    public function packageNameOfPageShouldBe($pageString, $project, $versionString, $name)
    {
        $page = $this->documenter->documentationPage($project, $versionString, $pageString);

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($name, $page->projectName());
    }

    /**
     * @Then documentation time of :pageString page for :project version :versionString should be :time
     */
    public function timeOfPageShouldBe($pageString, $project, $versionString, DateTimeImmutable $time)
    {
        $page = $this->documenter->documentationPage($project, $versionString, $pageString);

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($time, $page->documentedAt());
    }

    /**
     * @Then current version of :project documentation should point to version :versionString
     */
    public function currentVersionOfDocumentationShouldPointToVersion($project, $versionString)
    {
        $page = $this->documenter->documentationPage($project, $versionString, 'index.html');

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($versionString, $page->versionString());
    }

    /**
     * @Then documentation for :versionString should be in the list of available documentation for :project
     */
    public function documentationVersionShouldBeInTheList($project, $versionString)
    {
        PHPUnit_Framework_Assert::assertContains(
            (string)(new DocumentationId($project, $versionString)),
            array_map(
                function (PublishedDocumentation $documentation) {
                    return (string)$documentation->documentationId();
                },
                $this->documenter->allProjectDocumentation($project)
            ),
            'Documentation for provided version not found in the list.'
        );
    }
}
