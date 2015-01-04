<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\PackageDocumentation\DownloadBuilder;
use Behat\Borg\DocumentationManager;
use Behat\Borg\PackageDocumentation\ReleaseDocumentationId;
use Behat\Borg\Release\ReleaseDownloader;
use Behat\Borg\Release\Repository;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\Version;
use Behat\Borg\ReleaseManager;
use Fake\Documentation\FakeBuilder;
use Fake\Documentation\FakePublisher;
use Fake\Documentation\FakeSource;
use Fake\Documentation\FakeSourceFinder;
use Fake\Release\FakeDownloader;
use Fake\Release\FakeRepository;
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
        $finder = new FakeSourceFinder();
        $this->downloader = new FakeDownloader();
        $builder = new FakeBuilder();

        $this->releaseManager = new ReleaseManager();
        $this->documentationManager = new DocumentationManager($builder, $publisher);

        $downloadingListener = new ReleaseDownloader($this->downloader);
        $documentingListener = new DownloadBuilder($finder, $this->documentationManager);

        $this->releaseManager->registerListener($downloadingListener);
        $downloadingListener->registerListener($documentingListener);
    }

    /**
     * @Given :package version :version was documented in :repository on :time
     */
    public function releaseWasDocumentedOn($package, Version $version, Repository $repository, DateTimeImmutable $time)
    {
        $this->downloader->releaseWasDocumented(new Release($repository, $version), $time, new FakeSource());
    }

    /**
     * @Given :package version :version was documented in :repository
     */
    public function releaseWasDocumented($package, Version $version, Repository $repository)
    {
        $this->releaseWasDocumentedOn($package, $version, $repository, new DateTimeImmutable());
    }

    /**
     * @Given :package version :version was not documented
     */
    public function releaseWasNotDocumented(Repository $package, Version $version)
    {
    }

    /**
     * @When I release :package version :version
     */
    public function iReleaseRelease(Repository $package, Version $version)
    {
        $this->releaseManager->release(new Release($package, $version));
    }

    /**
     * @Then :package version :version documentation should have been published
     */
    public function releaseDocumentationShouldHaveBeenPublished(Repository $package, Version $version)
    {
        PHPUnit::assertNotNull(
            $this->documentationManager->findPage(
                $this->getDocumentationId($package, $version),
                new PageId('index.html')
            )
        );
    }

    /**
     * @Then :package version :version documentation should not be published
     */
    public function versionDocumentationShouldNotBePublished(Repository $package, Version $version)
    {
        PHPUnit::assertNull(
            $this->documentationManager->findPage(
                $this->getDocumentationId($package, $version),
                new PageId('index.html')
            )
        );
    }

    /**
     * @Then package name of :pageId page for :package version :version should be :name
     */
    public function packageNameOfPageShouldBe(PageId $pageId, Repository $package, Version $version, $name)
    {
        $page = $this->documentationManager->findPage($this->getDocumentationId($package, $version), $pageId);

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($name, $page->getProjectName());
    }

    /**
     * @Then documentation time of :pageId page for :package version :version should be :time
     */
    public function timeOfPageShouldBe(PageId $pageId, Repository $package, Version $version, DateTimeImmutable $time)
    {
        $page = $this->documentationManager->findPage($this->getDocumentationId($package, $version), $pageId);

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($time, $page->getDocumentationTime());
    }

    /**
     * @Then documentation for :version should be in the list of available documentation for :projectName
     */
    public function documentationVersionShouldBeInTheList($projectName, Version $version)
    {
        PHPUnit_Framework_Assert::assertContains(
            $this->getDocumentationId(FakeRepository::named($projectName), $version),
            array_map(
                function (PublishedDocumentation $documentation) {
                    return $documentation->getDocumentationId();
                },
                $this->documentationManager->getAvailableDocumentation($projectName)
            ),
            'Documentation for provided version not found in the list.',
            false,
            false
        );
    }

    private function getDocumentationId(Repository $package, Version $version)
    {
        return new ReleaseDocumentationId(new Release($package, $version));
    }
}
