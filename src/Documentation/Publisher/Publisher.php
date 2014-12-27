<?php

namespace Behat\Borg\Documentation\Publisher;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use InvalidArgumentException;

/**
 * Publishes built documentation.
 */
interface Publisher
{
    /**
     * Publishes provided built documentation.
     *
     * @param BuiltDocumentation $builtDocumentation
     */
    public function publishDocumentation(BuiltDocumentation $builtDocumentation);

    /**
     * Checks if documentation with the id was published.
     *
     * @param DocumentationId $anId
     *
     * @return Boolean
     */
    public function hasPublishedDocumentation(DocumentationId $anId);

    /**
     * Gets published documentation by its unique ID.
     *
     * @param DocumentationId $anId
     *
     * @return PublishedDocumentation
     *
     * @throws InvalidArgumentException If documentation was not published
     */
    public function getPublishedDocumentation(DocumentationId $anId);
}
