<?php

namespace Behat\Borg\DocumentationBuilder\InMemory;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use InvalidArgumentException;

/**
 * Stores and exposes built documentation in memory.
 */
final class InMemoryBuiltDocumentationRepository implements BuiltDocumentationRepository
{
    private $documentation;

    /**
     * {@inheritdoc}
     */
    public function addBuiltDocumentation(BuiltDocumentation $builtDocumentation)
    {
        $this->documentation['' . $builtDocumentation->getId()] = $builtDocumentation;
    }

    /**
     * {@inheritdoc}
     */
    public function hasBuiltDocumentation(DocumentationId $anId)
    {
        // TODO: Implement hasBuiltDocumentation() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getBuiltDocumentation(DocumentationId $anId)
    {
        if (!isset($this->documentation['' . $anId])) {
            throw new InvalidArgumentException('Built documentation was not found');
        }

        return $this->documentation['' . $anId];
    }
}
