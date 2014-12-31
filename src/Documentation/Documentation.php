<?php

namespace Behat\Borg\Documentation;

use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Downloader\Download;
use DateTimeImmutable;

/**
 * Represents raw, unprocessed documentation.
 */
final class Documentation
{
    private $anId;
    private $time;
    private $source;

    /**
     * Initializes documentation after it was downloaded.
     *
     * @param Download $download
     * @param Source   $source
     *
     * @return Documentation
     */
    public static function downloaded(Download $download, Source $source)
    {
        $documentation = new Documentation();
        $documentation->anId = new ReleaseDocumentationId($download->getRelease());
        $documentation->time = $download->getReleaseTime();
        $documentation->source = $source;

        return $documentation;
    }

    /**
     * Returns documentation ID.
     *
     * @return DocumentationId
     */
    public function getId()
    {
        return $this->anId;
    }

    /**
     * Returns documentation source.
     *
     * @return Source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Returns time documentation was built at.
     *
     * @return DateTimeImmutable
     */
    public function getTime()
    {
        return $this->time;
    }

    private function __construct() { }
}
