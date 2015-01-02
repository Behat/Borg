<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\PackageDocumentation\DownloadBuilder;
use Behat\Borg\DocumentationManager;
use Behat\Borg\PackageDocumentation\ReleaseDocumentationId;
use Behat\Borg\Package\ReleaseDownloader;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Behat\Borg\ReleaseManager;
use Fake\Documentation\FakeBuilder;
use Fake\Documentation\FakePublisher;
use Fake\Documentation\FakeSource;
use Fake\Documentation\FakeSourceFinder;
use Fake\Package\FakeDownloader;
use Fake\Package\FakePackage;
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
     * @Given :package version :version was documented on :time
     */
    public function releaseWasDocumentedOn(Package $package, Version $version, DateTimeImmutable $time)
    {
        $this->downloader->releaseWasDocumented(new Release($package, $version), $time, new FakeSource());
    }

    /**
     * @Given :package version :version was documented
     */
    public function releaseWasDocumented(Package $package, Version $version)
    {
        $this->releaseWasDocumentedOn($package, $version, new DateTimeImmutable());
    }

    /**
     * @Given :package version :version was not documented
     */
    public function releaseWasNotDocumented(Package $package, Version $version)
    {
    }

    /**
     * @When I release :package version :version
     */
    public function iReleaseRelease(Package $package, Version $version)
    {
        $this->releaseManager->release(new Release($package, $version));
    }

    /**
     * @Then :package version :version documentation should have been published
     */
    public function releaseDocumentationShouldHaveBeenPublished(Package $package, Version $version)
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
    public function versionDocumentationShouldNotBePublished(Package $package, Version $version)
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
    public function packageNameOfPageShouldBe(PageId $pageId, Package $package, Version $version, $name)
    {
        $page = $this->documentationManager->findPage($this->getDocumentationId($package, $version), $pageId);

        PHPUnit::assertNotNull($page, 'Page not found.');
        PHPUnit::assertEquals($name, $page->getProjectName());
    }

    /**
     * @Then documentation time of :pageId page for :package version :version should be :time
     */
    public function timeOfPageShouldBe(PageId $pageId, Package $package, Version $version, DateTimeImmutable $time)
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
            $this->getDocumentationId(FakePackage::named($projectName), $version),
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

    private function getDocumentationId(Package $package, Version $version)
    {
        return new ReleaseDocumentationId(new Release($package, $version));
    }
}
