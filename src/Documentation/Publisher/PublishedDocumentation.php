<?php

namespace Behat\Borg\Documentation\Publisher;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
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
        $publishedDocumentation = new PublishedDocumentation();
        $publishedDocumentation->id = $builtDocumentation->getId();
        $publishedDocumentation->buildTime = $builtDocumentation->getBuildTime();
        $publishedDocumentation->documentationTime = $builtDocumentation->getDocumentationTime();
        $publishedDocumentation->path = $path;

        return $publishedDocumentation;
    }

    /**
     * Returns documentation id.
     *
     * @return DocumentationId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns time documentation was built.
     *
     * @return DateTimeImmutable
     */
    public function getBuildTime()
    {
        return $this->buildTime;
    }

    /**
     * Returns time documentation was written.
     *
     * @return DateTimeImmutable
     */
    public function getDocumentationTime()
    {
        return $this->documentationTime;
    }

    /**
     * Returns path documentation was published to.
     *
     * @return string
     */
    public function getPublishPath()
    {
        return $this->path;
    }

    private function __construct() { }
}
