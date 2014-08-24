<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Documentation\InMemory\InMemoryDocumentationProvider;

/**
 * Describes documentation-related features from the documentation manager context.
 */
class DocumentationManagerContext implements Context, SnippetAcceptingContext
{
    private $documentationProvider;
    private $builtDocumentationRepository;
    private $documentationManager;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $this->documentationProvider = new InMemoryDocumentationProvider();
        $this->builtDocumentationRepository = new InMemoryBuiltDocumentationRepository();
        $this->documentationManager = new DocumentationManager(
            $this->documentationProvider,
            $this->builtDocumentationRepository
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
        $source = RstDocumentationSource::atPath(__DIR__ . '/fixtures');
        $documentation = new Documentation($id, $source);

        $this->documentationProvider->registerDocumentation($documentation);
    }

    /**
     * @When I build the documentation
     */
    public function iBuildTheDocumentation()
    {
        $this->documentationManager->buildDocumentation();
    }

    /**
     * @Then the documentation for :package version :version should have been built
     */
    public function thePackageDocumentationShouldHaveBeenBuilt(Package $package, Version $version)
    {
        $id = new PackageDocumentationId($package, $version);
        $builtDocumentation = $this->builtDocumentationRepository->getBuiltDocumentation($id);

        PHPUnit_Framework_Assert::assertFileExists($builtDocumentation->getIndexPath());
    }
}
