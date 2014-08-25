<?php

namespace Behat\Borg\Documentation\InMemory;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationProvider;

/**
 * Stores and exposes documentation from the process memory.
 */
final class InMemoryDocumentationProvider implements DocumentationProvider
{
    private $documentation = [];

    /**
     * {@inheritdoc}
     */
    public function addDocumentation(Documentation $documentation)
    {
        $this->documentation[] = $documentation;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllDocumentation()
    {
        return $this->documentation;
    }
}
