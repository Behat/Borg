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
     * @param DocumentationId     $anId
     * @param DocumentationSource $source
     * @param DateTimeImmutable   $time
     */
    public function __construct(
        DocumentationId $anId,
        DocumentationSource $source,
        DateTimeImmutable $time = null
    ) {
        $this->anId = $anId;
        $this->source = $source;
        $this->time = $time ?: new DateTimeImmutable();
    }

    /**
     * @return DocumentationId
     */
    public function getId()
    {
        return $this->anId;
    }

    /**
     * @return DocumentationSource
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getTime()
    {
        return $this->time;
    }
}
