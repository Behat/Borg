<?php

namespace Behat\Borg;

use Behat\Borg\Documentation\DocumentationProvider;
use Behat\Borg\DocumentationBuilder\DocumentationBuilder;

/**
 * Manages documentation.
 */
final class DocumentationManager
{
    private $provider;
    private $builder;

    /**
     * @param DocumentationProvider $provider
     * @param DocumentationBuilder  $builder
     */
    public function __construct(DocumentationProvider $provider, DocumentationBuilder $builder)
    {
        $this->provider = $provider;
        $this->builder = $builder;
    }

    /**
     * Builds all documentation from provider using builder.
     */
    public function buildDocumentation()
    {
        foreach ($this->provider->getAllDocumentation() as $documentation) {
            $this->builder->build($documentation);
        }
    }
}
