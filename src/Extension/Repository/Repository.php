<?php

namespace Behat\Borg\Extension\Repository;

use Behat\Borg\Extension\Extension;

/**
 * Stores extensions.
 */
interface Repository
{
    /**
     * Saves provided extension into the repository.
     *
     * @param Extension $extension
     */
    public function save(Extension $extension);

    /**
     * Find stored extension by name.
     *
     * @param string $name
     *
     * @return null|Extension
     */
    public function find($name);

    /**
     * Returns all stored extensions.
     *
     * @return Extension[]
     */
    public function findAll();
}
