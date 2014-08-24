<?php

namespace Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;

final class RegisteringDocumentationBuilder implements DocumentationBuilder
{
    public function __construct(
        DocumentationBuilder $actualBuilder,
        BuiltDocumentationRepository $repository
    ) {
        // TODO: write logic here
    }

    public function build(Documentation $documentation)
    {
        // TODO: Implement build() method.
    }
}
