<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\DownloadBuilder;
use Behat\Borg\Documentation\BuildPublisher;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
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
        $downloadingListener = new ReleaseDownloader($downloader);
        $documentingListener = new DownloadBuilder($this->finder, $builder);
        $publishingListener = new BuildPublisher($this->publisher);

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
    public function releaseWasDocumented(Package $package, Version $version)
    {
        $this->finder->releaseWasDocumented(new Release($package, $version), new FakeSource());
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
        PHPUnit::assertTrue(
            $this->publisher->hasPublishedDocumentation(
                new ReleaseDocumentationId(new Release($package, $version))
            )
        );
    }
}
