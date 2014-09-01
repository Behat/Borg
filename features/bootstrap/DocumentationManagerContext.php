<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\DocumentationBuilder\BuildSpecification\UpdateableBuildSpecification;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
use Behat\Borg\DocumentationBuilder\SpecificationBasedDocumentationBuilder;
use Behat\Borg\DocumentationManager;
use Behat\Borg\Fake\Documentation\FakeDocumentationProvider;
use Behat\Borg\Fake\Documentation\FakeDocumentationSource;
use Behat\Borg\Fake\DocumentationBuilder\FakeBuiltDocumentationRepository;
use Behat\Borg\Fake\DocumentationBuilder\Generator\FakeDocumentationGenerator;
use Behat\Borg\Package\Documentation\PackageDocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Version;

/**
 * Describes documentation-related features from the documentation manager context.
 */
class DocumentationManagerContext implements Context, SnippetAcceptingContext
{
    private $documentationProvider;
    private $builtDocumentationRepository;
    private $documentationManager;
    private $generator;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $this->documentationProvider = new FakeDocumentationProvider();
        $this->builtDocumentationRepository = new FakeBuiltDocumentationRepository();
        $this->generator = new FakeDocumentationGenerator();
        $specification = new UpdateableBuildSpecification($this->builtDocumentationRepository);

        $documentationBuilder = new SpecificationBasedDocumentationBuilder($specification, $this->generator);
        $this->documentationManager = new DocumentationManager(
            $this->documentationProvider, $documentationBuilder, $this->builtDocumentationRepository
        );
    }

    /**
     * @Transform :package
     */
    public function transformStringToPackage($string)
    {
        return Package::fromName($string);
    }

    /**
     * @Transform :version
     */
    public function transformStringToVersion($string)
    {
        return Version::fromString($string);
    }

    /**
     * @Given :package version :version was documented
     */
    public function packageWasDocumented(Package $package, Version $version)
    {
        $id = new PackageDocumentationId($package, $version);
        $source = new FakeDocumentationSource();
        $documentation = new Documentation($id, $source, $this->createTime('19.01.1988 18:00'));

        $this->documentationProvider->wasDocumented($documentation);
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
        $id = new PackageDocumentationId($package, $version);
        $source = new FakeDocumentationSource();
        $documentation = new Documentation($id, $source, $this->createTime('20.01.1988 16:00'));

        $this->documentationProvider->wasDocumented($documentation);
    }

    /**
     * @When I build the documentation
     */
    public function iBuildTheDocumentation()
    {
        $this->generator->changeBuildTime($this->createTime('19.01.1988 20:00'));
        $this->documentationManager->buildDocumentation();
    }

    /**
     * @When I build the documentation again
     */
    public function iBuildTheDocumentationAgain()
    {
        $this->generator->changeBuildTime($this->createTime('20.01.1988 20:00'));
        $this->documentationManager->buildDocumentation();
    }

    /**
     * @Then the documentation for :package version :version should have been built
     */
    public function thePackageDocumentationShouldHaveBeenBuilt(Package $package, Version $version)
    {
        $this->getBuiltDocumentationForPackageVersion($package, $version);
    }

    /**
     * @Then the documentation for :package version :version should have been rebuilt
     */
    public function thePackageDocumentationShouldHaveBeenRebuilt(
        Package $package,
        Version $version
    ) {
        $builtDocumentation = $this->getBuiltDocumentationForPackageVersion($package, $version);
        $documentationBuildTime = $builtDocumentation->getBuildTime();

        PHPUnit_Framework_Assert::assertGreaterThanOrEqual(
            $this->generator->getLastBuildTime(),
            $documentationBuildTime
        );
    }

    /**
     * @Then the documentation for :package version :version should not have been rebuilt
     */
    public function thePackageDocumentationShouldNotHaveBeenRebuilt(
        Package $package,
        Version $version
    ) {
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
        $id = new PackageDocumentationId($package, $version);
        $builtDocumentation = $this->builtDocumentationRepository->getBuiltDocumentation($id);

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
