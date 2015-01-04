<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Package\ReleasePackager;
use Behat\Borg\PackageDocumentation\PackageDocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\PackageDocumentation\PackageDocumentationBuilder;
use Behat\Borg\DocumentationManager;
use Behat\Borg\Release\ReleaseDownloader;
use Behat\Borg\Release\Repository;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\Version;
use Behat\Borg\ReleaseManager;
use Fake\Documentation\FakeBuilder;
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
        $this->downloader->releaseWasDocumented(new Release($repository, $version), $time, new FakeSource());
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
     * @Then :package version :version documentation should have been published
     */
    public function releaseDocumentationShouldHaveBeenPublished(Package $package, Version $version)
    {
        PHPUnit::assertNotNull(
            $this->documentationManager->findPage(
                new PackageDocumentationId($package, $version), new PageId('index.html')
            )
        );
    }

    /**
     * @Then :package version :version documentation should not be published
     */
    public function versionDocumentationShouldNotBePublished(Package $package, Version $version)
    {
        PHPUnit::assertNull(
            $this->documentationManager->findPage(
                new PackageDocumentationId($package, $version), new PageId('index.html')
            )
        );
    }

    /**
     * @Then package name of :pageId page for :package version :version should be :name
     */
    public function packageNameOfPageShouldBe(PageId $pageId, Package $package, Version $version, $name)
    {
        $page = $this->documentationManager->findPage(new PackageDocumentationId($package, $version), $pageId);

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($name, $page->getProjectName());
    }

    /**
     * @Then documentation time of :pageId page for :package version :version should be :time
     */
    public function timeOfPageShouldBe(PageId $pageId, Package $package, Version $version, DateTimeImmutable $time)
    {
        $page = $this->documentationManager->findPage(new PackageDocumentationId($package, $version), $pageId);

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($time, $page->getDocumentationTime());
    }

    /**
     * @Then documentation for :version should be in the list of available documentation for :package
     */
    public function documentationVersionShouldBeInTheList(Package $package, Version $version)
    {
        PHPUnit_Framework_Assert::assertContains(
            new PackageDocumentationId($package, $version),
            array_map(
                function (PublishedDocumentation $documentation) {
                    return $documentation->getDocumentationId();
                },
                $this->documentationManager->getAvailableDocumentation($package)
            ),
            'Documentation for provided version not found in the list.',
            false,
            false
        );
    }
}
