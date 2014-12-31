<?php

namespace Behat\Borg\Documentation\Page;

use Behat\Borg\Documentation\DocumentationId;

/**
 * Represents a documentation page ID.
 */
final class PageId
{
    /**
     * @var DocumentationId
     */
    private $documentationId;
    /**
     * @var string
     */
    private $path;

    /**
     * Initializes ID.
     *
     * @param DocumentationId $documentationId
     * @param string          $path
     */
    public function __construct(DocumentationId $documentationId, $path)
    {
        $this->documentationId = $documentationId;
        $this->path = $path;
    }

    /**
     * Returns documentation ID.
     *
     * @return DocumentationId
     */
    public function getDocumentationId()
    {
        return $this->documentationId;
    }

    /**
     * Returns relative path to the page file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
