<?php

namespace Behat\Borg\DocumentationBuilder\InMemory;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
use Behat\Borg\DocumentationBuilder\BuiltDocumentationRepository;
use InvalidArgumentException;

final class InMemoryBuiltDocumentationRepository implements BuiltDocumentationRepository
{
    public function addBuiltDocumentation(BuiltDocumentation $builtDocumentation)
    {
        // TODO: Implement addBuiltDocumentation() method.
    }

    public function getBuiltDocumentation(DocumentationId $anId)
    {
        throw new InvalidArgumentException('Built documentation was not found');
    }
}
