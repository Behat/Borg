<?php

namespace Behat\Borg\Documentation\Builder\BuildSpecification;

use Behat\Borg\Documentation\Builder\BuiltDocumentationRepository;
use Behat\Borg\Documentation\Documentation;

/**
 * Allows builds of new or outdated documentation only.
 */
final class UpdateableBuildSpecification implements DocumentationBuildSpecification
{
    private $repository;

    /**
     * @param BuiltDocumentationRepository $repository
     */
    public function __construct(BuiltDocumentationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedByDocumentation(Documentation $documentation)
    {
        $anId = $documentation->getId();
        if (!$this->repository->hasBuiltDocumentation($anId)) {
            return true;
        }

        $builtDocumentation = $this->repository->getBuiltDocumentation($anId);
        if ($builtDocumentation->getDocumentationTime() < $documentation->getTime()) {
            return true;
        }

        return false;
    }
}
