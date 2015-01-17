<?php

namespace Behat\Borg\Documentation\Page;

use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use DateTimeImmutable;

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
     * @var DateTimeImmutable
     */
    private $time;

    /**
     * Initializes page.
     *
     * @param PublishedDocumentation $documentation
     * @param PageId                 $pageId
     */
    public function __construct(PublishedDocumentation $documentation, PageId $pageId)
    {
        $this->path = $documentation->pagePath($pageId);
        $this->projectName = $documentation->documentationId()->projectName();
        $this->versionString = $documentation->documentationId()->versionString();
        $this->time = $documentation->documentedAt();
    }

    /**
     * Returns a documented project name.
     *
     * @return string
     */
    public function projectName()
    {
        return $this->projectName;
    }

    /**
     * Returns a documented project version string.
     *
     * @return string
     */
    public function versionString()
    {
        return $this->versionString;
    }

    /**
     * Returns the time at which documentation was last edited.
     *
     * @return DateTimeImmutable
     */
    public function documentedAt()
    {
        return $this->time;
    }

    /**
     * Returns absolute path to a file.
     *
     * @return string
     */
    public function path()
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
        return $this->path();
    }
}
