<?php

use Behat\Behat\Tester\Exception\PendingException;
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
    private $downloader;
    private $releaseManager;
    private $documentationManager;

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
     * @Transform :date
     */
    public function transformStringToDate($string)
    {
        return DateTimeImmutable::createFromFormat('d.m.Y', $string);
    }

    /**
     * @Given :package version :version was documented on :date
     */
    public function releaseWasDocumentedOn(Package $package, Version $version, DateTimeImmutable $date)
    {
        $this->downloader->releaseWasDocumented(new Release($package, $version), $date, new FakeSource());
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

    /**
     * @When :arg1 version :arg2 built documentation is published
     */
    public function versionBuiltDocumentationIsPublished($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then package name of :arg1 page for :arg2 version :arg3 should be :arg4
     */
    public function packageNameOfPageForVersionShouldBe($arg1, $arg2, $arg3, $arg4)
    {
        throw new PendingException();
    }

    /**
     * @Then documentation time of :arg1 page for :arg2 version :arg3 should be :arg4
     */
    public function documentationTimeOfPageForVersionShouldBe($arg1, $arg2, $arg3, $arg4)
    {
        throw new PendingException();
    }
}
