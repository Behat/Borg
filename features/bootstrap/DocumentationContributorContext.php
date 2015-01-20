<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Application\Infrastructure\Documentation\PersistedObjectsRepository;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\ProjectDocumentationId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\DocumentationPackage\PackageDocumenter;
use Behat\Borg\Documenter;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\ReleasePackager;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\ReleaseDownloader;
use Behat\Borg\Release\Version;
use Behat\Borg\ReleaseManager;
use Fake\Documentation\FakeBuilder;
use Fake\Documentation\FakePublisher;
use Fake\Documentation\FakeSourceFinder;
use Fake\Package\FakePackageFinder;
use Fake\Release\FakeDownloader;
use Fake\Release\FakeRepository;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Describes documentation-related features from the documentation manager context.
 */
class DocumentationContributorContext implements Context, SnippetAcceptingContext
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
        $this->documenter = new Documenter(new FakeBuilder(), new FakePublisher(), new PersistedObjectsRepository(null));
        $this->releaseManager = new ReleaseManager();

        $releaseDownloader = new ReleaseDownloader(new FakeDownloader());
        $releasePackager = new ReleasePackager(new FakePackageFinder());
        $packageDocumenter = new PackageDocumenter(new FakeSourceFinder(), $this->documenter);

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
        $this->releaseManager->release(new Release($repository, $version));
    }

    /**
     * @Then :project version :versionString documentation should have been published
     */
    public function releaseDocumentationShouldHaveBeenPublished($project, $versionString)
    {
        PHPUnit::assertNotNull(
            $this->documenter->findPage(
                new ProjectDocumentationId($project, $versionString), new PageId('index.html')
            )
        );
    }

    /**
     * @Then :project version :versionString documentation should not be published
     */
    public function versionDocumentationShouldNotBePublished($project, $versionString)
    {
        PHPUnit::assertNull(
            $this->documenter->findPage(
                new ProjectDocumentationId($project, $versionString), new PageId('index.html')
            )
        );
    }

    /**
     * @Then package name of :pageId page for :project version :versionString should be :name
     */
    public function packageNameOfPageShouldBe(PageId $pageId, $project, $versionString, $name)
    {
        $documentationId = new ProjectDocumentationId($project, $versionString);
        $page = $this->documenter->findPage($documentationId, $pageId);

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($name, $page->projectName());
    }

    /**
     * @Then documentation time of :pageId page for :project version :versionString should be :time
     */
    public function timeOfPageShouldBe(PageId $pageId, $project, $versionString, DateTimeImmutable $time)
    {
        $documentationId = new ProjectDocumentationId($project, $versionString);
        $page = $this->documenter->findPage($documentationId, $pageId);

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($time, $page->documentedAt());
    }

    /**
     * @Then current version of :project documentation should point to version :versionString
     */
    public function currentVersionOfDocumentationShouldPointToVersion($project, $versionString)
    {
        $documentationId = new ProjectDocumentationId($project, 'current');
        $page = $this->documenter->findPage($documentationId, new PageId('index.html'));

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($versionString, $page->versionString());
    }

    /**
     * @Then documentation for :versionString should be in the list of available documentation for :project
     */
    public function documentationVersionShouldBeInTheList($project, $versionString)
    {
        PHPUnit_Framework_Assert::assertContains(
            (string)(new ProjectDocumentationId($project, $versionString)),
            array_map(
                function (PublishedDocumentation $documentation) {
                    return (string)$documentation->documentationId();
                },
                $this->documenter->findProjectDocumentation($project)
            ),
            'Documentation for provided version not found in the list.'
        );
    }
}
