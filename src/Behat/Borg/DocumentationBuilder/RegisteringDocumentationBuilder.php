<?php

namespace Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;

final class RegisteringDocumentationBuilder implements DocumentationBuilder
{
    private $actualBuilder;
    private $repository;

    public function __construct(
        DocumentationBuilder $actualBuilder,
        BuiltDocumentationRepository $repository
    ) {
        $this->actualBuilder = $actualBuilder;
        $this->repository = $repository;
    }

    public function build(Documentation $documentation)
    {
        $this->actualBuilder->build($documentation);
    }
}
