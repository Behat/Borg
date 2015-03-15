<?php

namespace Behat\Borg\Integration\Extension;

use Behat\Borg\Extension\Exception\ExtensionNotFound;
use Behat\Borg\Extension\Extension;
use Behat\Borg\Extension\Repository\Repository;
use Everzet\PersistedObjects\FileRepository;
use Everzet\PersistedObjects\InMemoryRepository;
use Everzet\PersistedObjects\ObjectIdentifier;

final class PersistedObjectsRepository implements Repository, ObjectIdentifier
{
    private $repo;

    public function __construct($path)
    {
        $this->repo = $path ? new FileRepository($path, $this) : new InMemoryRepository($this);
    }

    public function add(Extension $extension)
    {
        $this->repo->save($extension);
    }

    public function extension($name)
    {
        $extension = $this->repo->findById($name);

        if (!$extension) {
            throw new ExtensionNotFound('Extension was not found.');
        }

        return $extension;
    }

    public function all()
    {
        return $this->repo->getAll();
    }

    public function getIdentity($object)
    {
        return (string)$object;
    }
}
