<?php

namespace Smoke;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Github\Client;
use PHPUnit_Framework_Assert as PHPUnit;
use Transformation;

/**
 * Defines application features from the specific context.
 */
class ExtensionUIContext extends RawMinkContext implements Context
{
    use Transformation\CleanBuildCache;

    private $client;

    /**
     * Initializes context.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @Given :extension extension package was created in :repository
     */
    public function extensionWasCreated($repository, $extension)
    {
        PHPUnit::assertTrue($this->repositoryExtensionIs($repository, $extension), 'Repository does not contain expected extension.');
    }

    /**
     * @Then the extension catalogue should contain :count extension(s)
     * @Then the extension catalogue should still contain :count extension(s)
     * @Then the extension catalogue should be empty
     */
    public function extensionCatalogueShouldHaveCount($count = 0)
    {
        $this->visitPath('/extensions');
        $this->assertSession()->elementsCount('css', '.extension', $count);
    }

    /**
     * @Then :name extension should be in the catalogue
     */
    public function extensionShouldBeInTheCatalogue($name)
    {
        $this->visitPath('/extensions');
        $this->getSession()->getPage()->clickLink($name);
        $this->assertSession()->elementContains('css', 'h1', $name);
    }

    private function repositoryExtensionIs($repository, $extension)
    {
        $content = $this->contentInRepository($repository, 'composer.json');

        return 1 === preg_match('#"name"\s*:\s*"' . preg_quote($extension) . '"#', $content);
    }

    private function contentInRepository($repository, $path)
    {
        $repositoryParts = explode('/', $repository);

        return file_get_contents($this->client->repo()->contents()->show($repositoryParts[0], $repositoryParts[1], $path)['download_url']);
    }
}
