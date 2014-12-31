<?php

namespace Behat\Borg\Documentation\Page;

use Behat\Borg\Documentation\Publisher\PublishedDocumentation;

/**
 * Represents a documentation page.
 */
final class Page
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $projectName;
    /**
     * @var string
     */
    private $versionString;

    /**
     * Initializes page.
     *
     * @param PublishedDocumentation $documentation
     * @param PageId                 $pageId
     */
    public function __construct(PublishedDocumentation $documentation, PageId $pageId)
    {
        $this->path = $documentation->getPagePath($pageId);
        $this->projectName = $documentation->getDocumentationId()->getProjectName();
        $this->versionString = $documentation->getDocumentationId()->getVersionString();
    }

    /**
     * Returns a documented project name.
     *
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * Returns a documented project version string.
     *
     * @return string
     */
    public function getVersionString()
    {
        return $this->versionString;
    }

    /**
     * Returns absolute path to a file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
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
