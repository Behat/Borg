<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Listener\DocumentingDownloadListener;
use Behat\Borg\Documentation\Listener\PublishingBuildListener;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Listener\DownloadingReleaseListener;
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
    private $publisher;
    private $releaseManager;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $this->publisher = new FakePublisher();
        $this->finder = new FakeSourceFinder();
        $downloader = new FakeDownloader();
        $builder = new FakeBuilder();

        $this->releaseManager = new ReleaseManager();
        $downloadingListener = new DownloadingReleaseListener($downloader);
        $documentingListener = new DocumentingDownloadListener($this->finder, $builder);
        $publishingListener = new PublishingBuildListener($this->publisher);

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
        $this->finder->releaseWasDocumented(new Release($package, $version), new FakeSource());
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
        PHPUnit::assertTrue(
            $this->publisher->hasPublishedDocumentation(
                new ReleaseDocumentationId(new Release($package, $version))
            )
        );
    }
}
