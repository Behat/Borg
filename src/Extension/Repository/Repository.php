<?php

namespace Behat\Borg\Extension\Repository;

use Behat\Borg\Extension\Exception\ExtensionNotFound;
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
    public function add(Extension $extension);

    /**
     * Find stored extension by name.
     *
     * @param string $name
     *
     * @return Extension
     *
     * @throws ExtensionNotFound
     */
    public function extension($name);

    /**
     * Returns all stored extensions.
     *
     * @return Extension[]
     */
    public function all();
}
