<?php

namespace Behat\Borg\SphinxDoc\Documentation;

use Behat\Borg\Documentation\DocumentationSource;

final class RstDocumentationSource implements DocumentationSource
{
    private $path;

    private function __construct($path)
    {
        $this->path = $path;
    }

    public static function atPath($path)
    {
        return new self($path);
    }

    public function getPath()
    {
        return $this->path;
    }
}
