<?php

namespace Behat\Borg\Documentation;

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
     * @param DocumentationId   $anId
     * @param DateTimeImmutable $time
     * @param Source            $source
     */
    public function __construct(DocumentationId $anId, DateTimeImmutable $time, Source $source)
    {
        $this->anId = $anId;
        $this->time = $time;
        $this->source = $source;
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
}
