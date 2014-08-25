<?php

namespace Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\DocumentationBuilder\BuildSpecification\DocumentationBuildSpecification;
use InvalidArgumentException;

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

        $builtDocumentation = $this->actualBuilder->build($documentation);

        if (!$builtDocumentation) {
            throw new InvalidArgumentException('Documentation can not be built.');
        }

        $this->repository->addBuiltDocumentation($builtDocumentation);

        return $builtDocumentation;
    }
}
