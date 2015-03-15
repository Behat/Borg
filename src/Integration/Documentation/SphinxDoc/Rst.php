<?php

namespace Behat\Borg\Integration\Documentation\SphinxDoc;

use Behat\Borg\Documentation\Source;

/**
 * Represents *.rst documentation source.
 *
 * Used by sphinx-doc (http://sphinx-doc.org).
 */
final class Rst implements Source
{
    private $path;

    /**
     * Constructs documentation source from provided source path.
     *
     * @param string $path
     *
     * @return Rst
     */
    public static function atPath($path)
    {
        $source = new Rst();
        $source->path = $path;

        return $source;
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    private function __construct() { }
}
