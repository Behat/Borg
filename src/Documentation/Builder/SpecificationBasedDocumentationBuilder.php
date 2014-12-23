<?php

namespace Behat\Borg\Documentation\Builder;

use Behat\Borg\Documentation\Builder\BuildSpecification\DocumentationBuildSpecification;
use Behat\Borg\Documentation\Builder\Generator\DocumentationGenerator;
use Behat\Borg\Documentation\Documentation;
use InvalidArgumentException;

/**
 * Builds documentation using generator based on specification and writes result into repository.
 */
final class SpecificationBasedDocumentationBuilder implements DocumentationBuilder
{
    private $specification;
    private $generator;

    /**
     * @param DocumentationBuildSpecification $specification
     * @param DocumentationGenerator          $generator
     */
    public function __construct(
        DocumentationBuildSpecification $specification,
        DocumentationGenerator $generator
    ) {
        $this->specification = $specification;
        $this->generator = $generator;
    }

    /**
     * {@inheritdoc}
     */
    public function build(Documentation $documentation)
    {
        if (!$this->specification->isSatisfiedByDocumentation($documentation)) {
            return null;
        }

        $builtDocumentation = $this->generator->generate($documentation);

        if (!$builtDocumentation) {
            throw new InvalidArgumentException('Documentation can not be built.');
        }

        return $builtDocumentation;
    }
}
