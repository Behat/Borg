<?php

namespace Behat\Borg\Application\Infrastructure\Documentation;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Repository\Repository;
use Everzet\PersistedObjects\FileRepository;
use Everzet\PersistedObjects\ObjectIdentifier;

final class FilesystemRepository implements Repository, ObjectIdentifier
{
    public function __construct($path)
    {
        $this->repo = new FileRepository($path, $this);
    }

    public function save(PublishedDocumentation $documentation)
    {
        $this->repo->save($documentation);
    }

    public function find(DocumentationId $documentationId)
    {
        return $this->repo->findById((string)$documentationId);
    }

    public function findForProject($projectName)
    {
        $documentation = array_filter(
            $this->repo->getAll(),
            function (PublishedDocumentation $documentation) use ($projectName) {
                return strtolower($projectName) == $documentation->getDocumentationId()->getProjectName();
            }
        );

        usort($documentation, [$this, 'compareVersions']);

        return $documentation;
    }

    public function getIdentity($object)
    {
        return (string)$object->getDocumentationId();
    }

    private function compareVersions(PublishedDocumentation $a, PublishedDocumentation $b)
    {
        $versionA = $a->getDocumentationId()->getVersionString();
        $versionB = $b->getDocumentationId()->getVersionString();

        return version_compare($versionB, $versionA);
    }
}
