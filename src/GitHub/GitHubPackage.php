<?php

namespace Behat\Borg\GitHub;

use Behat\Borg\Package\Package;

/**
 * Represents a GitHub package.
 */
final class GitHubPackage implements Package
{
    private $name;

    public static function named($name)
    {
        if (!preg_match('/^[\w\d]+\/[\w\d]+$/', $name)) {
            throw new \InvalidArgumentException('Invalid GitHub package name provided.');
        }

        $package = new GitHubPackage();
        $package->name = $name;

        return $package;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrganisation()
    {
        return explode('/', $this->name)[0];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return explode('/', $this->name)[1];
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->name;
    }

    private function __construct() { }
}
