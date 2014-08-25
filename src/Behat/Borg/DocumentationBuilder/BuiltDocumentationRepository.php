<?php

namespace Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\DocumentationId;

interface BuiltDocumentationRepository
{
    public function getBuiltDocumentation(DocumentationId $anId);
    public function addBuiltDocumentation(BuiltDocumentation $builtDocumentation);
}
