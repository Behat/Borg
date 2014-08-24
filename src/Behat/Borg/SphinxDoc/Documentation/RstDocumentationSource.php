<?php

namespace Behat\Borg\SphinxDoc\Documentation;

use Behat\Borg\Documentation\DocumentationSource;

final class RstDocumentationSource implements DocumentationSource
{
    private function __construct()
    {
    }

    public static function atPath($path)
    {
        return new self($path);
    }
}
