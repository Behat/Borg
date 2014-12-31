<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Page\PageId;
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
    private $finder;
    private $releaseManager;
    private $documentationManager;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $publisher = new FakePublisher();
        $this->finder = new FakeSourceFinder();
        $downloader = new FakeDownloader();
        $builder = new FakeBuilder();

        $this->releaseManager = new ReleaseManager();
        $this->documentationManager = new DocumentationManager($builder, $publisher);

        $downloadingListener = new ReleaseDownloader($downloader);
        $documentingListener = new DownloadBuilder($this->finder, $this->documentationManager);

        $this->releaseManager->registerListener($downloadingListener);
        $downloadingListener->registerListener($documentingListener);
    }

    /**
     * @Transform :package
     */
    public function transformStringToPackage($string)
    {
        return FakePackage::named($string);
    }

    /**
     * @Transform :version
     */
    public function transformStringToVersion($string)
    {
        return Version::string($string);
    }

    /**
     * @Given :package version :version was documented
     */
    public function releaseWasDocumented(Package $package, Version $version)
    {
        $this->finder->releaseWasDocumented(new Release($package, $version), new FakeSource());
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
                new ReleaseDocumentationId(new Release($package, $version)),
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
                new ReleaseDocumentationId(new Release($package, $version)),
                new PageId('index.html')
            )
        );
    }
}
