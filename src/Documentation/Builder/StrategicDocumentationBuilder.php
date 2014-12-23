<?php

namespace Behat\Borg\Documentation\Builder;

use Behat\Borg\Documentation\Builder\Generator\DocumentationGenerator;
use Behat\Borg\Documentation\Builder\Strategy\BuildStrategy;
use Behat\Borg\Documentation\Documentation;
use InvalidArgumentException;

/**
 * Builds documentation using generator based on build strategy and writes result into repository.
 */
final class StrategicDocumentationBuilder implements DocumentationBuilder
{
    private $strategy;
    private $generator;

    /**
     * @param BuildStrategy          $strategy
     * @param DocumentationGenerator $generator
     */
    public function __construct(BuildStrategy $strategy, DocumentationGenerator $generator)
    {
        $this->strategy = $strategy;
        $this->generator = $generator;
    }

    /**
     * {@inheritdoc}
     */
    public function build(Documentation $documentation)
    {
        if (!$this->strategy->isSatisfiedByDocumentation($documentation)) {
            return null;
        }

        $builtDocumentation = $this->generator->generate($documentation);

        if (!$builtDocumentation) {
            throw new InvalidArgumentException('Documentation can not be built.');
        }

        return $builtDocumentation;
    }
}
