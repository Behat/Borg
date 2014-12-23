<?php

namespace Behat\Borg\Documentation\Builder;

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
     * Checks if repository already has built documentation with an id.
     *
     * @param DocumentationId $anId
     *
     * @return Boolean
     */
    public function hasBuiltDocumentation(DocumentationId $anId);

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
