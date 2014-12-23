<?php

namespace Behat\Borg\Fake\Documentation\Builder;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Builder\BuiltDocumentationRepository;
use Behat\Borg\Documentation\DocumentationId;
use InvalidArgumentException;

/**
 * Stores and exposes built documentation in memory.
 */
final class FakeBuiltDocumentationRepository implements BuiltDocumentationRepository
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
        return isset($this->documentation['' . $anId]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBuiltDocumentation(DocumentationId $anId)
    {
        if (!$this->hasBuiltDocumentation($anId)) {
            throw new InvalidArgumentException('Built documentation was not found');
        }

        return $this->documentation['' . $anId];
    }
}
