<?php

namespace Behat\Borg\Documentation\Page;

use Behat\Borg\Documentation\Publisher\PublishedDocumentation;

/**
 * Represents an absolute path to a documentation file.
 */
final class Page
{
    /**
     * @var PublishedDocumentation
     */
    private $documentation;
    /**
     * @var PageId
     */
    private $pageId;

    /**
     * Initializes page.
     *
     * @param PublishedDocumentation $documentation
     * @param PageId                 $pageId
     */
    public function __construct(PublishedDocumentation $documentation, PageId $pageId)
    {
        $this->documentation = $documentation;
        $this->pageId = $pageId;
    }

    /**
     * Returns absolute path to a file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->documentation->getPagePath($this->pageId);
    }

    /**
     * Returns absolute file path.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getPath();
    }
}
