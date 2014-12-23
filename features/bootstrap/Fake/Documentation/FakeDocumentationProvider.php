<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationProvider;

/**
 * Stores and exposes documentation from the process memory.
 */
final class FakeDocumentationProvider implements DocumentationProvider
{
    private $documentation = [];

    /**
     * {@inheritdoc}
     */
    public function wasDocumented(Documentation $documentation)
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
