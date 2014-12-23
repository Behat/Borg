<?php

namespace Behat\Borg\SphinxDoc;

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
        $source = new RstDocumentationSource();
        $source->path = $path;

        return $source;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    private function __construct() { }
}
