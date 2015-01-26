<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Borg\Extension\Extension;
use Behat\Borg\Release\Repository;
use Behat\MinkExtension\Context\RawMinkContext;
use Github\Client;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Defines application features from the specific context.
 */
class ExtensionUIContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
    use Transformation\Extension;

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
     * @Given :extension extension was created in :repository
     */
    public function extensionWasCreated(Repository $repository, Extension $extension)
    {
        PHPUnit::assertTrue(
            $this->repositoryExtensionIs($repository, $extension),
            'Repository does not contain expected extension.'
        );
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

    private function repositoryExtensionIs(Repository $repository, Extension $extension)
    {
        $content = $this->contentInRepository($repository, 'composer.json');

        return 1 === preg_match('#"name":\s*"' . preg_quote((string)$extension) . '"#', $content);
    }

    private function contentInRepository(Repository $repository, $path)
    {
        return file_get_contents(
            $this->client->repo()->contents()->show(
                (string)$repository->organisationName(), (string)$repository->name(), $path
            )['download_url']
        );
    }
}
