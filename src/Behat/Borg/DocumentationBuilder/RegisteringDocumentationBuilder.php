<?php

namespace Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;
use InvalidArgumentException;

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
        $builtDocumentation = $this->actualBuilder->build($documentation);

        if (!$builtDocumentation) {
            throw new InvalidArgumentException('Documentation can not be built.');
        }

        return $builtDocumentation;
    }
}
