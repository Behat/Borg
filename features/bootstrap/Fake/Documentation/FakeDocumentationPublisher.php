<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationPublisher;
use InvalidArgumentException;

/**
 * Stores and exposes built documentation in memory.
 */
final class FakeDocumentationPublisher implements DocumentationPublisher
{
    private $documentation;

    /**
     * {@inheritdoc}
     */
    public function publishDocumentation(BuiltDocumentation $builtDocumentation)
    {
        $this->documentation['' . $builtDocumentation->getId()] = $builtDocumentation;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPublishedDocumentation(DocumentationId $anId)
    {
        return isset($this->documentation['' . $anId]);
    }

    /**
     * {@inheritdoc}
     */
    public function getPublishedDocumentation(DocumentationId $anId)
    {
        if (!$this->hasPublishedDocumentation($anId)) {
            throw new InvalidArgumentException('Built documentation was not found');
        }

        return $this->documentation['' . $anId];
    }
}
