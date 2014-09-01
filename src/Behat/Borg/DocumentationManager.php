<?php

namespace Behat\Borg;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Builder\BuiltDocumentationRepository;
use Behat\Borg\Documentation\Builder\DocumentationBuilder;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationProvider;

/**
 * Manages documentation.
 */
final class DocumentationManager
{
    private $provider;
    private $builder;
    private $repository;

    /**
     * @param DocumentationProvider        $provider
     * @param DocumentationBuilder         $builder
     * @param BuiltDocumentationRepository $repository
     */
    public function __construct(
        DocumentationProvider $provider,
        DocumentationBuilder $builder,
        BuiltDocumentationRepository $repository
    ) {
        $this->provider = $provider;
        $this->builder = $builder;
        $this->repository = $repository;
    }

    /**
     * Builds all documentation from provider using builder.
     */
    public function buildDocumentation()
    {
        foreach ($this->provider->getAllDocumentation() as $documentation) {
            $this->buildSingleDocumentation($documentation);
        }
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

        $this->repository->addBuiltDocumentation($builtDocumentation);
    }

    /**
     * Returns already built documentation using documentation identity.
     *
     * @param DocumentationId $anId
     *
     * @return BuiltDocumentation
     */
    public function getBuiltDocumentation(DocumentationId $anId)
    {
        return $this->repository->getBuiltDocumentation($anId);
    }
}
