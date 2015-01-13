<?php

namespace Behat\Borg\Documentation\Repository;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;

/**
 * Stores published documentation.
 */
interface Repository
{
    /**
     * Saves published documentation to the repository.
     *
     * @param PublishedDocumentation $documentation
     */
    public function save(PublishedDocumentation $documentation);

    /**
     * Finds documentation by its id.
     *
     * @param DocumentationId $documentationId
     *
     * @return null|PublishedDocumentation
     */
    public function find(DocumentationId $documentationId);

    /**
     * Finds all documentation for particular project.
     *
     * @param string $projectName
     *
     * @return PublishedDocumentation[]
     */
    public function findAll($projectName);
}
