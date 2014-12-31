<?php

namespace Behat\Borg;

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
     * @param PageId $anId
     *
     * @return null|Page
     */
    public function findPage(PageId $anId)
    {
        $documentationId = $anId->getDocumentationId();
        if (!$this->publisher->hasPublished($documentationId)) {
            return null;
        }

        $documentation = $this->publisher->getPublished($documentationId);
        if (!$documentation->hasPage($anId)) {
            return null;
        }

        return $documentation->getPage($anId);
    }
}
