<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\ProjectDocumentationId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Package\ReleasePackager;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Documentation\PackageDocumentationBuilder;
use Behat\Borg\DocumentationManager;
use Behat\Borg\Release\ReleaseDownloader;
use Behat\Borg\Release\Repository;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\Version;
use Behat\Borg\ReleaseManager;
use Fake\Documentation\FakeBuilder;
use Fake\Documentation\FakeDocumentedDownload;
use Fake\Documentation\FakePublisher;
use Fake\Documentation\FakeSource;
use Fake\Documentation\FakeSourceFinder;
use Fake\Package\FakePackageFinder;
use Fake\Release\FakeDownloader;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Describes documentation-related features from the documentation manager context.
 */
class DocumentationContributorContext implements Context, SnippetAcceptingContext
{
    private $downloader;
    private $releaseManager;
    private $documentationManager;

    use DocumentationTransformations;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $publisher = new FakePublisher();
        $sourceFinder = new FakeSourceFinder();
        $packageFinder = new FakePackageFinder();
        $this->downloader = new FakeDownloader();
        $builder = new FakeBuilder();

        $this->releaseManager = new ReleaseManager();
        $this->documentationManager = new DocumentationManager($builder, $publisher);

        $releaseDownloader = new ReleaseDownloader($this->downloader);
        $releasePackager = new ReleasePackager($packageFinder);
        $documentingBuilder = new PackageDocumentationBuilder($sourceFinder, $this->documentationManager);

        $this->releaseManager->registerListener($releaseDownloader);
        $releaseDownloader->registerListener($releasePackager);
        $releasePackager->registerListener($documentingBuilder);
    }

    /**
     * @Given :package version :version was documented in :repository on :time
     */
    public function packageWasDocumentedOn(Package $package, Version $version, Repository $repository, DateTimeImmutable $time)
    {
        $release = new Release($repository, $version);
        $download = new FakeDocumentedDownload($release, $time, $package, new FakeSource());
        $this->downloader->addReleaseDownload($release, $download);
    }

    /**
     * @Given :package version :version was documented in :repository
     */
    public function packageWasDocumented(Package $package, Version $version, Repository $repository)
    {
        $this->packageWasDocumentedOn($package, $version, $repository, new DateTimeImmutable());
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
        $this->releaseManager->release(new Release($repository, $version));
    }

    /**
     * @Then :project version :versionString documentation should have been published
     */
    public function releaseDocumentationShouldHaveBeenPublished($project, $versionString)
    {
        PHPUnit::assertNotNull(
            $this->documentationManager->findPage(
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
            $this->documentationManager->findPage(
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
        $page = $this->documentationManager->findPage($documentationId, $pageId);

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($name, $page->getProjectName());
    }

    /**
     * @Then documentation time of :pageId page for :project version :versionString should be :time
     */
    public function timeOfPageShouldBe(PageId $pageId, $project, $versionString, DateTimeImmutable $time)
    {
        $documentationId = new ProjectDocumentationId($project, $versionString);
        $page = $this->documentationManager->findPage($documentationId, $pageId);

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($time, $page->getDocumentationTime());
    }

    /**
     * @Then current version of :project documentation should point to version :versionString
     */
    public function currentVersionOfDocumentationShouldPointToVersion($project, $versionString)
    {
        $documentationId = new ProjectDocumentationId($project, 'current');
        $page = $this->documentationManager->findPage($documentationId, new PageId('index.html'));

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($versionString, $page->getVersionString());
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
                    return (string)$documentation->getDocumentationId();
                },
                $this->documentationManager->getAvailableDocumentation($project)
            ),
            'Documentation for provided version not found in the list.'
        );
    }
}
