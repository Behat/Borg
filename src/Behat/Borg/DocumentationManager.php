<?php

namespace Behat\Borg;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationProvider;
use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use Behat\Borg\DocumentationBuilder\DocumentationBuilder;

/**
 * Manages documentation.
 */
final class DocumentationManager
{
    private $provider;
    private $builder;
    private $repository;

    /**
     * @param DocumentationProvider $provider
     * @param DocumentationBuilder $builder
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
}
