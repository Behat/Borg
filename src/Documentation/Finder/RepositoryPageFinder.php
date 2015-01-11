<?php

namespace Behat\Borg\Documentation\Finder;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Repository\Repository;

/**
 * Documentation repository-based page finder.
 */
final class RepositoryPageFinder implements PageFinder
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * Initializes page finder.
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function findPage(DocumentationId $documentationId, PageId $pageId)
    {
        if (!$documentation = $this->repository->find($documentationId)) {
            return null;
        }

        if (!$documentation->hasPage($pageId)) {
            return null;
        }

        return $documentation->getPage($pageId);
    }
}
