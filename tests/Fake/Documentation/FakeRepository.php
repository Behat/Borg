<?php

namespace tests\Behat\Borg\Fake\Documentation;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Repository\Repository;
use Everzet\PersistedObjects\InMemoryRepository;
use Everzet\PersistedObjects\ObjectIdentifier;

final class FakeRepository implements Repository, ObjectIdentifier
{
    private $repository;

    public function __construct()
    {
        $this->repository = new InMemoryRepository($this);
    }

    public function save(PublishedDocumentation $published)
    {
        $this->repository->save($published);
    }

    public function find(DocumentationId $anId)
    {
        return $this->repository->findById((string)$anId);
    }

    public function findForProject($projectName)
    {
        return array_filter(
            $this->repository->getAll(),
            function (PublishedDocumentation $documentation) use ($projectName) {
                return strtolower($projectName) == $documentation->getDocumentationId()->getProjectName();
            }
        );
    }

    public function getIdentity($object)
    {
        return (string)$object->getDocumentationId();
    }
}
