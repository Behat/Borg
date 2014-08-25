<?php

namespace Behat\Borg\DocumentationBuilder\InMemory;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use InvalidArgumentException;

final class InMemoryBuiltDocumentationRepository implements BuiltDocumentationRepository
{
    private $documentation;

    public function addBuiltDocumentation(BuiltDocumentation $builtDocumentation)
    {
        $this->documentation['' . $builtDocumentation->getId()] = $builtDocumentation;
    }

    public function getBuiltDocumentation(DocumentationId $anId)
    {
        if (!isset($this->documentation['' . $anId])) {
            throw new InvalidArgumentException('Built documentation was not found');
        }

        return $this->documentation['' . $anId];
    }
}
