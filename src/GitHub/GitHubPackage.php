<?php

namespace Behat\Borg\GitHub;

use Behat\Borg\GitHub\Exception\BadRepositoryNameGiven;
use Behat\Borg\Package\Package;

/**
 * Represents a GitHub package.
 */
final class GitHubPackage implements Package
{
    private $repositoryString;
    private $organisation;
    private $repository;

    /**
     * Initializes GitHub package.
     *
     * @param $repositoryString
     *
     * @return GitHubPackage
     *
     * @throws BadRepositoryNameGiven
     */
    public static function named($repositoryString)
    {
        if (!preg_match('/^[\w\-]++\/[\w\-]++$/', $repositoryString)) {
            throw new BadRepositoryNameGiven(
                "`{$repositoryString}` is not a supported GitHub repository name."
            );
        }

        $package = new GitHubPackage();
        $package->repositoryString = $repositoryString;
        list($package->organisation, $package->repository) = explode('/', $repositoryString);

        return $package;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->repositoryString;
    }

    private function __construct() { }
}
