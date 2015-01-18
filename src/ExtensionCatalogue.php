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
     * Registers provided extension.
     *
     * @param Extension $extension
     */
    public function register(Extension $extension)
    {
        $this->repository->save($extension);
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

    /**
     * Returns all catalogued extensions.
     */
    public function getAll()
    {
        return $this->repository->findAll();
    }
}
