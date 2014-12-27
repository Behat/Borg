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
    private $source;
    private $time;

    /**
     * Initializes documentation after it was downloaded.
     *
     * @param Download            $download
     * @param DocumentationSource $source
     *
     * @return Documentation
     */
    public static function downloaded(Download $download, DocumentationSource $source)
    {
        $documentation = new Documentation();
        $documentation->anId = new ReleaseDocumentationId($download->getRelease());
        $documentation->source = $source;
        $documentation->time = $download->getReleaseTime();

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
     * @return DocumentationSource
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
