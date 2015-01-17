<?php

namespace Behat\Borg\Documentation\Publisher;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Exception\PageNotFound;
use Behat\Borg\Documentation\Page\Page;
use Behat\Borg\Documentation\Page\PageId;
use DateTimeImmutable;

/**
 * Represents a documentation that was published.
 */
final class PublishedDocumentation
{
    private $id;
    private $buildTime;
    private $documentationTime;
    private $path;

    /**
     * Initializes published documentation.
     *
     * @param BuiltDocumentation $builtDocumentation
     * @param string             $path
     *
     * @return PublishedDocumentation
     */
    public static function publish(BuiltDocumentation $builtDocumentation, $path)
    {
        $documentation = new PublishedDocumentation();
        $documentation->id = $builtDocumentation->documentationId();
        $documentation->buildTime = $builtDocumentation->builtAt();
        $documentation->documentationTime = $builtDocumentation->documentedAt();
        $documentation->path = $path;

        return $documentation;
    }

    /**
     * Returns documentation id.
     *
     * @return DocumentationId
     */
    public function documentationId()
    {
        return $this->id;
    }

    /**
     * Returns time documentation was built.
     *
     * @return DateTimeImmutable
     */
    public function builtAt()
    {
        return $this->buildTime;
    }

    /**
     * Returns time documentation was written.
     *
     * @return DateTimeImmutable
     */
    public function documentedAt()
    {
        return $this->documentationTime;
    }

    /**
     * Checks if file at provided relative path exists.
     *
     * @param PageId $anId
     *
     * @return Boolean
     */
    public function hasPage(PageId $anId)
    {
        return file_exists($this->path . '/' . $anId);
    }

    /**
     * Returns page by its ID.
     *
     * @param PageId $anId
     *
     * @return Page
     */
    public function page(PageId $anId)
    {
        if (!$this->hasPage($anId)) {
            throw new PageNotFound("Documentation page `{$anId->path()}` was not found.");
        }

        return new Page($this, $anId);
    }

    /**
     * Generates absolute file path for provided page ID.
     *
     * @param PageId $anId
     *
     * @return string
     */
    public function pagePath(PageId $anId)
    {
        if (!$this->hasPage($anId)) {
            throw new PageNotFound("Documentation page `{$anId->path()}` was not found.");
        }

        return $this->path . '/' . $anId;
    }

    private function __construct() { }
}
