<?php

namespace Behat\Borg\Documentation\Finder;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Page\Page;
use Behat\Borg\Documentation\Page\PageId;

/**
 * Responsible for finding documentation pages.
 */
interface PageFinder
{
    /**
     * Tries to find provided documentation page.
     *
     * @param DocumentationId $documentationId
     * @param PageId          $pageId
     *
     * @return null|Page
     */
    public function findPage(DocumentationId $documentationId, PageId $pageId);
}
