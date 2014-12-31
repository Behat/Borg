<?php

namespace Behat\Borg;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Page\Page;
use Behat\Borg\Documentation\Publisher\Publisher;

/**
 * Manages documentation by providing high-level accessor methods.
 */
final class DocumentationManager
{
    /**
     * @var Publisher
     */
    private $publisher;

    /**
     * Initialize manager.
     *
     * @param Publisher $publisher
     */
    public function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * Tries to find the documentation page using its ID.
     *
     * @param DocumentationId $documentationId
     * @param PageId          $pageId
     *
     * @return Page|null
     */
    public function findPage(DocumentationId $documentationId, PageId $pageId)
    {
        if (!$this->publisher->hasPublished($documentationId)) {
            return null;
        }

        $documentation = $this->publisher->getPublished($documentationId);
        if (!$documentation->hasPage($pageId)) {
            return null;
        }

        return $documentation->getPage($pageId);
    }
}
