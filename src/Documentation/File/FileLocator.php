<?php

namespace Behat\Borg\Documentation\File;

use Behat\Borg\Documentation\DocumentationId;

/**
 * Represents a documentation file locator.
 */
final class FileLocator
{
    /**
     * @var DocumentationId
     */
    private $id;
    /**
     * @var string
     */
    private $relativePath;

    /**
     * Initializes locator.
     *
     * @param DocumentationId $anId
     * @param string          $relativePath
     *
     * @return FileLocator
     */
    public static function ofDocumentationFile(DocumentationId $anId, $relativePath)
    {
        $locator = new FileLocator();
        $locator->id = $anId;
        $locator->relativePath = $relativePath;

        return $locator;
    }

    /**
     * Returns documentation ID.
     *
     * @return DocumentationId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns relative path to the file.
     *
     * @return string
     */
    public function getRelativePath()
    {
        return $this->relativePath;
    }

    private function __construct() { }
}
