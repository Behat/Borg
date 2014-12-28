<?php

namespace Behat\Borg\Documentation\Publisher;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Exception\RequestedDocumentationWasNotPublished;

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
    public function publish(BuiltDocumentation $builtDocumentation);

    /**
     * Checks if documentation with the id was published.
     *
     * @param DocumentationId $anId
     *
     * @return Boolean
     */
    public function hasPublished(DocumentationId $anId);

    /**
     * Gets published documentation by its unique ID.
     *
     * @param DocumentationId $anId
     *
     * @return PublishedDocumentation
     *
     * @throws RequestedDocumentationWasNotPublished
     */
    public function getPublished(DocumentationId $anId);
}
