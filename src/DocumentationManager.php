<?php

namespace Behat\Borg;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Builder\DocumentationBuilder;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Provider\DocumentationProvider;
use Behat\Borg\Documentation\Publisher\DocumentationPublisher;

/**
 * Manages documentation.
 */
final class DocumentationManager
{
    private $provider;
    private $builder;
    private $publisher;

    /**
     * @param \Behat\Borg\Documentation\Provider\DocumentationProvider  $provider
     * @param \Behat\Borg\Documentation\Builder\DocumentationBuilder   $builder
     * @param DocumentationPublisher $publisher
     */
    public function __construct(
        DocumentationProvider $provider,
        DocumentationBuilder $builder,
        DocumentationPublisher $publisher
    ) {
        $this->provider = $provider;
        $this->builder = $builder;
        $this->publisher = $publisher;
    }

    /**
     * Builds all documentation from provider using builder and publishes it.
     */
    public function buildAndPublishDocumentation()
    {
        foreach ($this->provider->getAllDocumentation() as $documentation) {
            $this->buildSingleDocumentation($documentation);
        }
    }

    /**
     * Returns already built documentation using documentation identity.
     *
     * @param DocumentationId $anId
     *
     * @return \Behat\Borg\Documentation\Builder\BuiltDocumentation
     */
    public function getPublishedDocumentation(DocumentationId $anId)
    {
        return $this->publisher->getPublishedDocumentation($anId);
    }

    /**
     * Builds single documentation.
     *
     * @param Documentation $documentation
     */
    private function buildSingleDocumentation(Documentation $documentation)
    {
        $builtDocumentation = $this->builder->build($documentation);

        if (!$builtDocumentation) {
            return;
        }

        $this->publisher->publishDocumentation($builtDocumentation);
    }
}
