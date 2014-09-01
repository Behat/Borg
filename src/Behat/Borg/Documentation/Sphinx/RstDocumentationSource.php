<?php

namespace Behat\Borg\Documentation\Sphinx;

use Behat\Borg\Documentation\DocumentationSource;

/**
 * Represents *.rst documentation source.
 *
 * Used by sphinx-doc (http://sphinx-doc.org).
 */
final class RstDocumentationSource implements DocumentationSource
{
    private $path;

    /**
     * Constructs documentation source from provided source path.
     *
     * @param string $path
     *
     * @return RstDocumentationSource
     */
    public static function atPath($path)
    {
        return new self($path);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    private function __construct($path)
    {
        $this->path = $path;
    }
}
