<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\BuiltDocumentation;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\StrategicDocumentationBuilder;
use Behat\Borg\Documentation\Strategy\RefreshableBuildStrategy;
use Behat\Borg\DocumentationManager;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Fake\Documentation\FakeDocumentationProvider;
use Fake\Documentation\FakeDocumentationPublisher;
use Fake\Documentation\FakeDocumentationSource;
use Fake\Documentation\Generator\FakeDocumentationGenerator;
use Fake\Package\FakePackage;

/**
 * Describes documentation-related features from the documentation manager context.
 */
class DocumentationManagerContext implements Context, SnippetAcceptingContext
{
    private $provider;
    private $manager;
    private $generator;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $this->provider = new FakeDocumentationProvider();
        $this->generator = new FakeDocumentationGenerator();
        $publisher = new FakeDocumentationPublisher();

        $buildStrategy = new RefreshableBuildStrategy($publisher);
        $builder = new StrategicDocumentationBuilder($buildStrategy, $this->generator);
        $this->manager = new DocumentationManager($this->provider, $builder, $publisher);
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
     * @Given :package version :version documentation was built
     */
    public function packageDocumentationWasBuilt(Package $package, Version $version)
    {
        $this->packageWasDocumented($package, $version);
        $this->iBuildTheDocumentation();
    }

    /**
     * @When  :package version :version documentation is updated
     */
    public function packageDocumentationWasUpdated(Package $package, Version $version)
    {
        $id = new ReleaseDocumentationId(new Release($package, $version));
        $source = new FakeDocumentationSource();
        $documentation = new Documentation($id, $source, $this->createTime('20.01.1988 16:00'));

        $this->provider->wasDocumented($documentation);
    }

    /**
     * @When I build the documentation
     */
    public function iBuildTheDocumentation()
    {
        $this->generator->changeBuildTime($this->createTime('19.01.1988 20:00'));
        $this->manager->buildAndPublishDocumentation();
    }

    /**
     * @When I build the documentation again
     */
    public function iBuildTheDocumentationAgain()
    {
        $this->generator->changeBuildTime($this->createTime('20.01.1988 20:00'));
        $this->manager->buildAndPublishDocumentation();
    }

    /**
     * @Then the documentation for :package version :version should have been published
     */
    public function thePackageDocumentationShouldHaveBeenBuilt(Package $package, Version $version)
    {
        $this->getBuiltDocumentationForPackageVersion($package, $version);
    }

    /**
     * @Then the documentation for :package version :version should have been republished
     */
    public function thePackageDocumentationShouldHaveBeenRebuilt(Package $package, Version $version)
    {
        $builtDocumentation = $this->getBuiltDocumentationForPackageVersion($package, $version);
        $documentationBuildTime = $builtDocumentation->getBuildTime();

        PHPUnit_Framework_Assert::assertGreaterThanOrEqual(
            $this->generator->getLastBuildTime(),
            $documentationBuildTime
        );
    }

    /**
     * @Then the documentation for :package version :version should not have been republished
     */
    public function thePackageDocumentationShouldNotHaveBeenRebuilt(Package $package, Version $version)
    {
        $builtDocumentation = $this->getBuiltDocumentationForPackageVersion($package, $version);
        $documentationBuildTime = $builtDocumentation->getBuildTime();

        PHPUnit_Framework_Assert::assertLessThan(
            $this->generator->getLastBuildTime(),
            $documentationBuildTime
        );
    }

    /**
     * @param Package $package
     * @param Version $version
     *
     * @return BuiltDocumentation
     */
    private function getBuiltDocumentationForPackageVersion(Package $package, Version $version)
    {
        $id = new ReleaseDocumentationId(new Release($package, $version));
        $builtDocumentation = $this->manager->getPublishedDocumentation($id);

        return $builtDocumentation;
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
