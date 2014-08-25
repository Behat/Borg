<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\InMemory\InMemoryDocumentationProvider;
use Behat\Borg\DocumentationBuilder\BuildSpecification\UpdateableBuildSpecification;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
use Behat\Borg\DocumentationBuilder\InMemory\InMemoryBuiltDocumentationRepository;
use Behat\Borg\DocumentationBuilder\RegisteringDocumentationBuilder;
use Behat\Borg\DocumentationBuilder\RepositoryDocumentationBuilder;
use Behat\Borg\DocumentationManager;
use Behat\Borg\Package\Documentation\PackageDocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Version;
use Behat\Borg\SphinxDoc\Documentation\RstDocumentationSource;
use Behat\Borg\SphinxDoc\DocumentationBuilder\Generator\SphinxDocumentationGenerator;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Describes documentation-related features from the documentation manager context.
 */
class DocumentationManagerContext implements Context, SnippetAcceptingContext
{
    private $documentationProvider;
    private $builtDocumentationRepository;
    private $documentationManager;
    private $lastBuildTime;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $this->documentationProvider = new InMemoryDocumentationProvider();
        $this->builtDocumentationRepository = new InMemoryBuiltDocumentationRepository();

        (new Filesystem())->remove($tempPath = __DIR__ . '/../../test_temp/behat_output');

        $documentationBuilder = new RepositoryDocumentationBuilder(
            new UpdateableBuildSpecification($this->builtDocumentationRepository),
            new SphinxDocumentationGenerator($tempPath),
            $this->builtDocumentationRepository
        );

        $this->documentationManager = new DocumentationManager(
            $this->documentationProvider, $documentationBuilder
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
     * @When :package version :version documentation is updated
     */
    public function packageWasDocumented(Package $package, Version $version)
    {
        $id = new PackageDocumentationId($package, $version);
        $source = RstDocumentationSource::atPath(__DIR__ . '/fixtures/' . $id);
        $documentation = new Documentation($id, $source, new DateTimeImmutable());

        $this->documentationProvider->addDocumentation($documentation);
    }

    /**
     * @Given :package version :version documentation was built
     */
    public function behatVersionDocumentationWasBuilt(Package $package, Version $version)
    {
        $this->packageWasDocumented($package, $version);
        $this->iBuildTheDocumentation();
    }

    /**
     * @When I build the documentation
     */
    public function iBuildTheDocumentation()
    {
        $this->lastBuildTime = new DateTimeImmutable();
        $this->documentationManager->buildDocumentation();
    }

    /**
     * @When I build the documentation again
     */
    public function iBuildTheDocumentationAgain()
    {
        usleep(1500000);
        $this->iBuildTheDocumentation();
    }

    /**
     * @Then the documentation for :package version :version should have been built
     */
    public function thePackageDocumentationShouldHaveBeenBuilt(Package $package, Version $version)
    {
        $builtDocumentation = $this->getBuiltDocumentationForPackageVersion($package, $version);

        PHPUnit_Framework_Assert::assertFileExists($builtDocumentation->getIndexPath());
    }

    /**
     * @Then the documentation for :package version :version should have been rebuilt
     */
    public function thePackageDocumentationShouldHaveBeenRebuilt(Package $package, Version $version)
    {
        $builtDocumentation = $this->getBuiltDocumentationForPackageVersion($package, $version);
        $documentationBuildTime = $builtDocumentation->getBuildTime();

        PHPUnit_Framework_Assert::assertGreaterThanOrEqual($this->lastBuildTime, $documentationBuildTime);
    }

    /**
     * @Then the documentation for :package version :version should not have been rebuilt
     */
    public function thePackageDocumentationShouldNotHaveBeenRebuilt(Package $package, Version $version)
    {
        $builtDocumentation = $this->getBuiltDocumentationForPackageVersion($package, $version);
        $documentationBuildTime = $builtDocumentation->getBuildTime();

        PHPUnit_Framework_Assert::assertLessThan($this->lastBuildTime, $documentationBuildTime);
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
}
