<?php

namespace Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\DocumentationBuilder\BuildSpecification\DocumentationBuildSpecification;
use InvalidArgumentException;

final class RepositoryDocumentationBuilder implements DocumentationBuilder
{
    private $specification;
    private $actualBuilder;
    private $repository;

    public function __construct(
        DocumentationBuildSpecification $specification,
        DocumentationBuilder $actualBuilder,
        BuiltDocumentationRepository $repository
    ) {
        $this->specification = $specification;
        $this->actualBuilder = $actualBuilder;
        $this->repository = $repository;
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