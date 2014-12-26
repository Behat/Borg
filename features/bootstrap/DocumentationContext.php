<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Behat\Borg\ReleaseManager;
use Fake\Documentation\FakeDocumentationFinder;
use Fake\Documentation\FakeDocumentationPublisher;
use Fake\Documentation\FakeDocumentationSource;
use Fake\Package\FakePackage;

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
        $this->finder = new FakeDocumentationFinder();
        $this->releaseManager = new ReleaseManager();
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
        $id = new ReleaseDocumentationId(new Release($package, $version));
        $source = new FakeDocumentationSource();
        $documentation = new Documentation($id, $source, $this->createTime('19.01.1988 18:00'));

        $this->finder->addDocumentation($documentation);
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

    /**
     * @param string $time
     *
     * @return DateTimeImmutable
     */
    private function createTime($time)
    {
        return DateTimeImmutable::createFromFormat('d.m.Y H:i', $time);
    }
}
