<?php

namespace Behat\Borg\Documentation\Repository;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Exception\PageNotFound;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;

/**
 * Stores published documentation.
 */
interface Repository
{
    /**
     * Adds published documentation to the repository.
     *
     * @param PublishedDocumentation $documentation
     */
    public function add(PublishedDocumentation $documentation);

    /**
     * Gets documentation by its id.
     *
     * @param DocumentationId $documentationId
     *
     * @return PublishedDocumentation
     *
     * @throws PageNotFound
     */
    public function documentation(DocumentationId $documentationId);

    /**
     * Gets all documentation for a particular project.
     *
     * @param string $projectName
     *
     * @return PublishedDocumentation[]
     */
    public function projectDocumentation($projectName);
}
