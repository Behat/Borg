<?php

namespace Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\DocumentationId;
use InvalidArgumentException;

/**
 * Stores built documentation.
 */
interface BuiltDocumentationRepository
{
    /**
     * Adds built documentation into repository.
     *
     * @param BuiltDocumentation $builtDocumentation
     */
    public function addBuiltDocumentation(BuiltDocumentation $builtDocumentation);

    /**
     * Gets built documentation by its unique ID.
     *
     * @param DocumentationId $anId
     *
     * @return BuiltDocumentation
     *
     * @throws InvalidArgumentException If documentation not found in repository
     */
    public function getBuiltDocumentation(DocumentationId $anId);
}
