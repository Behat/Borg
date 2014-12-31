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
    private $pagePath;

    /**
     * Initializes ID.
     *
     * @param DocumentationId $documentationId
     * @param string          $pagePath
     */
    public function __construct(DocumentationId $documentationId, $pagePath)
    {
        $this->documentationId = $documentationId;
        $this->pagePath = $pagePath;
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
        return $this->pagePath;
    }
}
