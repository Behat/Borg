<?php

namespace Behat\Borg\Documentation;

/**
 * Represents raw, unprocessed documentation.
 */
final class Documentation
{
    private $anId;
    private $source;

    /**
     * @param DocumentationId     $anId
     * @param DocumentationSource $source
     */
    public function __construct(DocumentationId $anId, DocumentationSource $source)
    {
        $this->anId = $anId;
        $this->source = $source;
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
}
