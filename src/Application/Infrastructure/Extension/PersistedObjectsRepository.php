<?php

/*
 * This file is part of the borg.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Borg\Application\Infrastructure\Extension;

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

    public function save(Extension $extension)
    {
        $this->repo->save($extension);
    }

    public function find($name)
    {
        return $this->repo->findById($name);
    }

    public function findAll()
    {
        return $this->repo->getAll();
    }

    public function getIdentity($object)
    {
        return $object->name();
    }
}
