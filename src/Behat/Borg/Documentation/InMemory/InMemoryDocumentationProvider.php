<?php

namespace Behat\Borg\Documentation\InMemory;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationProvider;

final class InMemoryDocumentationProvider implements DocumentationProvider
{
    private $documentation = [];

    public function registerDocumentation(Documentation $documentation)
    {
        $this->documentation[] = $documentation;
    }

    public function getAllDocumentation()
    {
        return $this->documentation;
    }
}
