<?php

namespace Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\DocumentationBuilder\BuildSpecification\DocumentationBuildSpecification;

final class UpdatingDocumentationBuilder implements DocumentationBuilder
{
    private $actualBuilder;
    private $repository;
    private $specification;

    public function __construct(
        DocumentationBuilder $actualBuilder,
        BuiltDocumentationRepository $repository,
        DocumentationBuildSpecification $specification
    ) {
        $this->actualBuilder = $actualBuilder;
        $this->repository = $repository;
        $this->specification = $specification;
    }

    /**
     * {@inheritdoc}
     */
    public function build(Documentation $documentation)
    {
        if (!$this->specification->isSatisfiedByDocumentation($documentation)) {
            return null;
        }

        $this->actualBuilder->build($documentation);
    }
}
