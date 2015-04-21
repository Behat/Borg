<?php

namespace Behat\Borg\Documentation\Page;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use DateTimeImmutable;

/**
 * Represents a documentation page.
 */
final class Page
{
    /**
     * @var DocumentationId
     */
    private $documentationId;
    /**
     * @var DateTimeImmutable
     */
    private $time;
    /**
     * @var string
     */
    private $path;

    /**
     * Initializes page.
     *
     * @param PublishedDocumentation $documentation
     * @param PageId                 $pageId
     */
    public function __construct(PublishedDocumentation $documentation, PageId $pageId)
    {
        $this->documentationId = $documentation->documentationId();
        $this->time = $documentation->documentedAt();
        $this->path = $documentation->path() . '/' . $pageId->path();
    }

    /**
     * Returns documentation project name.
     *
     * @return string
     */
    public function projectName()
    {
        return $this->documentationId->projectName();
    }

    /**
     * Returns documentation version string.
     *
     * @return string
     */
    public function versionString()
    {
        return $this->documentationId->versionString();
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
