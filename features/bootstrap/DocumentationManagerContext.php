<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\Publisher\Strategy\RefreshablePublishingStrategy;
use Behat\Borg\DocumentationManager;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Fake\Documentation\FakeDocumentationBuilder;
use Fake\Documentation\FakeDocumentationProvider;
use Fake\Documentation\FakeDocumentationPublisher;
use Fake\Documentation\FakeDocumentationSource;
use Fake\Package\FakePackage;

/**
 * Describes documentation-related features from the documentation manager context.
 */
class DocumentationManagerContext implements Context, SnippetAcceptingContext
{
    private $provider;
    private $manager;
    private $builder;
    private $publisher;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $this->provider = new FakeDocumentationProvider();
        $this->builder = new FakeDocumentationBuilder();
        $this->publisher = new FakeDocumentationPublisher();

        $publishingStrategy = new RefreshablePublishingStrategy($this->publisher);
        $this->manager = new DocumentationManager(
            $this->provider, $this->builder, $this->publisher, $publishingStrategy
        );
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

        $this->provider->wasDocumented($documentation);
    }

    /**
     * @When I release :package version :version
     */
    public function iReleasePackage(Package $package, Version $version)
    {
        $this->manager->publishAllDocumentation();
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
