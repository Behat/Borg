<?php

namespace Behat\Borg;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Builder\DocumentationBuilder;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Provider\DocumentationProvider;
use Behat\Borg\Documentation\Publisher\DocumentationPublisher;
use Behat\Borg\Documentation\Publisher\Strategy\PublishingStrategy;

/**
 * Manages documentation.
 */
final class DocumentationManager
{
    private $provider;
    private $builder;
    private $publisher;
    private $strategy;

    /**
     * @param DocumentationProvider  $provider
     * @param DocumentationBuilder   $builder
     * @param DocumentationPublisher $publisher
     * @param PublishingStrategy     $strategy
     */
    public function __construct(
        DocumentationProvider $provider,
        DocumentationBuilder $builder,
        DocumentationPublisher $publisher,
        PublishingStrategy $strategy
    ) {
        $this->provider = $provider;
        $this->builder = $builder;
        $this->publisher = $publisher;
        $this->strategy = $strategy;
    }

    /**
     * Builds all documentation from provider using builder and publishes it.
     */
    public function publishAllDocumentation()
    {
        foreach ($this->provider->getAllDocumentation() as $documentation) {
            if ($this->strategy->isSatisfiedByDocumentation($documentation)) {
                $this->publisher->publishDocumentation($this->buildDocumentation($documentation));
            }
        }
    }

    /**
     * Returns already built documentation using documentation identity.
     *
     * @param DocumentationId $anId
     *
     * @return BuiltDocumentation
     */
    public function getPublishedDocumentation(DocumentationId $anId)
    {
        return $this->publisher->getPublishedDocumentation($anId);
    }

    /**
     * Builds the single documentation.
     *
     * @param Documentation $documentation
     *
     * @return BuiltDocumentation|null
     */
    private function buildDocumentation(Documentation $documentation)
    {
        return $this->builder->build($documentation);
    }
}
