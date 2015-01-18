<?php

namespace Behat\Borg;

use Behat\Borg\Extension\Extension;
use Behat\Borg\Extension\Repository\Repository;

/**
 * Manages extension collection.
 */
final class ExtensionCatalogue
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Tries to find extension by name.
     *
     * @param string $name
     *
     * @return null|Extension
     */
    public function find($name)
    {
        return $this->repository->find($name);
    }
}
