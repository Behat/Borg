<?php

namespace Behat\Borg;

use Behat\Borg\Extension\Exception\ExtensionNotFound;
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

    /**
     * Initializes catalogue.
     *
     * @param Repository $repository
     */
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
        $this->repository->add($extension);
    }

    /**
     * Tries to find extension by name.
     *
     * @param string $name
     *
     * @return Extension
     *
     * @throws ExtensionNotFound
     */
    public function extension($name)
    {
        return $this->repository->extension($name);
    }

    /**
     * Returns all catalogued extensions.
     *
     * @return Extension[]
     */
    public function all()
    {
        return $this->repository->all();
    }
}
