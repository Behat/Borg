<?php

namespace Behat\Borg\Documentation;

/**
 * Provides all available documentation.
 */
interface DocumentationProvider
{
    /**
     * @param DocumentationId $anId
     *
     * @return null|Documentation
     */
    public function findDocumentationById(DocumentationId $anId);

    /**
     * @return Documentation[]
     */
    public function getAllDocumentation();
}
