<?php

namespace Behat\Borg;

use Behat\Borg\Documentation\DocumentationProvider;
use Behat\Borg\DocumentationBuilder\DocumentationBuilder;

final class DocumentationManager
{
    private $provider;
    private $builder;

    public function __construct(DocumentationProvider $provider, DocumentationBuilder $builder)
    {
        $this->provider = $provider;
        $this->builder = $builder;
    }

    public function buildDocumentation()
    {
        foreach ($this->provider->getAllDocumentation() as $documentation) {
            $this->builder->build($documentation);
        }
    }
}
