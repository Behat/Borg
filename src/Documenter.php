<?php

namespace Behat\Borg;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Exception\PageNotFound;
use Behat\Borg\Documentation\Publisher\Publisher;
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
     * @var Repository
     */
    private $repository;
    /**
     * @var Builder
     */
    private $builder;
    /**
     * @var Publisher
     */
    private $publisher;

    /**
     * Initialize manager.
     *
     * @param Builder    $builder
     * @param Publisher  $publisher
     * @param Repository $repository
     */
    public function __construct(Builder $builder, Publisher $publisher, Repository $repository)
    {
        $this->builder = $builder;
        $this->publisher = $publisher;
        $this->repository = $repository;
    }

    /**
     * Processes raw documentation.
     *
     * @param RawDocumentation $documentation
     */
    public function process(RawDocumentation $documentation)
    {
        $built = $this->builder->build($documentation);
        $published = $this->publisher->publish($built);
        $this->repository->add($published);
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
        $documentation = $this->repository->documentation($documentationId);

        if (!$documentation->hasPage($pageId)) {
            throw new PageNotFound('Page was not found.');
        }

        return $documentation->page($pageId);
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
        return $this->repository->projectDocumentation($projectName);
    }
}
