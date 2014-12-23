<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationProvider;

/**
 * Stores and exposes documentation from the process memory.
 */
final class FakeDocumentationProvider implements DocumentationProvider
{
    /**
     * @var Documentation[]
     */
    private $docs = [];

    /**
     * {@inheritdoc}
     */
    public function wasDocumented(Documentation $documentation)
    {
        $this->docs[] = $documentation;
    }

    /**
     * @param DocumentationId $anId
     *
     * @return null|Documentation
     */
    public function findDocumentationById(DocumentationId $anId)
    {
        foreach ($this->docs as $documentation) {
            if ($documentation->getId() == $anId) {
                return $documentation;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllDocumentation()
    {
        return $this->docs;
    }
}
