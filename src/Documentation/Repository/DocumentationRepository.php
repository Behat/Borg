<?php

namespace Behat\Borg\Documentation\Repository;

use Behat\Borg\Documentation\Publisher\PublishedDocumentation;

/**
 * Stores published documentation.
 */
interface DocumentationRepository
{
    /**
     * Saves published documentation to the repository.
     *
     * @param PublishedDocumentation $documentation
     */
    public function save(PublishedDocumentation $documentation);

    /**
     * Finds all documentation for particular project.
     *
     * @param string $projectName
     *
     * @return PublishedDocumentation[]
     */
    public function findForProject($projectName);
}
