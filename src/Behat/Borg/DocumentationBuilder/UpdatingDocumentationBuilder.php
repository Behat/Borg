<?php

namespace Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;

final class UpdatingDocumentationBuilder implements DocumentationBuilder
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

    /**
     * {@inheritdoc}
     */
    public function build(Documentation $documentation)
    {
        $anId = $documentation->getId();

        if ($this->repository->hasBuiltDocumentation($anId)) {
            $builtDocumentation = $this->repository->getBuiltDocumentation($anId);

            if ($builtDocumentation->getDocumentationTime() >= $documentation->getTime()) {
                return null;
            }
        }

        $this->actualBuilder->build($documentation);
    }
}
