<?php

namespace Behat\Borg;

use Behat\Borg\Documentation\Finder\PageFinder;
use Behat\Borg\Documentation\Processor\Processor;
use Behat\Borg\Documentation\RawDocumentation;
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
     * @var Processor
     */
    private $processor;
    /**
     * @var PageFinder
     */
    private $finder;
    /**
     * @var Repository
     */
    private $repository;

    /**
     * Initialize manager.
     *
     * @param Processor  $processor
     * @param PageFinder $finder
     * @param Repository $repository
     */
    public function __construct(Processor $processor, PageFinder $finder, Repository $repository)
    {
        $this->processor = $processor;
        $this->finder = $finder;
        $this->repository = $repository;
    }

    /**
     * Processes raw documentation.
     *
     * @param RawDocumentation $documentation
     */
    public function process(RawDocumentation $documentation)
    {
        $this->processor->process($documentation);
    }

    /**
     * Tries to find the documentation page using its ID.
     *
     * @param DocumentationId $documentationId
     * @param PageId          $pageId
     *
     * @return null|Page
     */
    public function findPage(DocumentationId $documentationId, PageId $pageId)
    {
        return $this->finder->findPage($documentationId, $pageId);
    }

    /**
     * Find all available documentation for a provided project.
     *
     * @param string $projectName
     *
     * @return PublishedDocumentation[]
     */
    public function findProjectDocumentation($projectName)
    {
        return $this->repository->findForProject($projectName);
    }
}
