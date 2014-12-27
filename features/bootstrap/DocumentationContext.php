<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\Listener\DocumentingDownloadListener;
use Behat\Borg\Documentation\Listener\PublishingDocumentationBuildListener;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Listener\DownloadingReleaseListener;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Behat\Borg\ReleaseManager;
use Fake\Documentation\FakeDocumentationBuilder;
use Fake\Documentation\FakeDocumentationSourceFinder;
use Fake\Documentation\FakeDocumentationPublisher;
use Fake\Documentation\FakeDocumentationSource;
use Fake\Package\FakePackage;
use Fake\Package\FakeReleaseDownloader;

/**
 * Describes documentation-related features from the documentation manager context.
 */
class DocumentationContext implements Context, SnippetAcceptingContext
{
    private $finder;
    private $publisher;
    private $releaseManager;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $this->publisher = new FakeDocumentationPublisher();
        $this->finder = new FakeDocumentationSourceFinder();
        $downloader = new FakeReleaseDownloader();
        $builder = new FakeDocumentationBuilder();

        $this->releaseManager = new ReleaseManager();
        $downloadingListener = new DownloadingReleaseListener($downloader);
        $documentingListener = new DocumentingDownloadListener($this->finder, $builder);
        $publishingListener = new PublishingDocumentationBuildListener($this->publisher);

        $this->releaseManager->registerListener($downloadingListener);
        $downloadingListener->registerListener($documentingListener);
        $documentingListener->registerListener($publishingListener);
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
    public function packageWasDocumented(Package $package, Version $version)
    {
        $release = new Release($package, $version);
        $source = new FakeDocumentationSource();

        $this->finder->releaseWasDocumented($release, $source);
    }

    /**
     * @When I release :package version :version
     */
    public function iReleasePackage(Package $package, Version $version)
    {
        $this->releaseManager->release(new Release($package, $version));
    }

    /**
     * @Then the documentation for :package version :version should have been published
     */
    public function thePackageDocumentationShouldHaveBeenBuilt(Package $package, Version $version)
    {
        $anId = new ReleaseDocumentationId(new Release($package, $version));
        PHPUnit_Framework_Assert::assertTrue($this->publisher->hasPublishedDocumentation($anId));
    }
}
