<?php

namespace Behat\Borg\Documentation\Repository;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;

/**
 * Dynamically adds support for `current` documentation to any repository.
 */
final class CurrentDocumentationRepository implements Repository
{
    /**
     * @var Repository
     */
    private $decorated;

    /**
     * Initializes repository.
     *
     * @param Repository $decoratedRepository
     */
    public function __construct(Repository $decoratedRepository)
    {
        $this->decorated = $decoratedRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function save(PublishedDocumentation $documentation)
    {
        $this->decorated->save($documentation);
    }

    /**
     * {@inheritdoc}
     */
    public function find(DocumentationId $documentationId)
    {
        if ('current' === $documentationId->getVersionString()) {
            return current($this->findForProject($documentationId->getProjectName()));
        }

        return $this->decorated->find($documentationId);
    }

    /**
     * {@inheritdoc}
     */
    public function findForProject($projectName)
    {
        return $this->decorated->findForProject($projectName);
    }
}
