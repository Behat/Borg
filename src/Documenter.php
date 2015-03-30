<?php

namespace Behat\Borg;

use Behat\Borg\Documentation\Exception\PageNotFound;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Page\Page;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Repository\Repository;

/**
 * Manages documentation by providing high-level accessor methods.
 */
final class Documenter
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * Initialize manager.
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Gets the documentation page using its ID.
     *
     * @param string $projectName
     * @param string $versionString
     * @param string $pageName
     *
     * @return Page
     *
     * @throws PageNotFound
     */
    public function documentationPage($projectName, $versionString, $pageName)
    {
        $documentationId = new DocumentationId($projectName, $versionString);
        $anId = new PageId($pageName);

        return $this->repository->documentation($documentationId)->page($anId);
    }

    /**
     * Gets all available documentation for a provided project.
     *
     * @param string $projectName
     *
     * @return PublishedDocumentation[]
     */
    public function allProjectDocumentation($projectName)
    {
        return $this->repository->allProjectDocumentation($projectName);
    }
}
