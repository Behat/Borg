<?php

namespace Behat\Borg\Documentation;

use DateTimeImmutable;

/**
 * Represents raw, unprocessed documentation.
 */
final class RawDocumentation
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
    public function documentationId()
    {
        return $this->anId;
    }

    /**
     * Returns documentation source.
     *
     * @return Source
     */
    public function source()
    {
        return $this->source;
    }

    /**
     * Returns time documentation was built at.
     *
     * @return DateTimeImmutable
     */
    public function documentedAt()
    {
        return $this->time;
    }
}
