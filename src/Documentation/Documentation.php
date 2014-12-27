<?php

namespace Behat\Borg\Documentation;

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
     * Initializes documentation.
     *
     * @param DocumentationId     $anId
     * @param DocumentationSource $source
     * @param DateTimeImmutable   $time
     */
    public function __construct(
        DocumentationId $anId,
        DocumentationSource $source,
        DateTimeImmutable $time
    ) {
        $this->anId = $anId;
        $this->source = $source;
        $this->time = $time;
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
}
