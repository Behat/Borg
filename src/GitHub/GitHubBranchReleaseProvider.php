<?php

namespace Behat\Borg\GitHub;

use Behat\Borg\Package\Package;
use Behat\Borg\Package\Provider\ReleaseProvider;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Github\Client;

final class GitHubBranchReleaseProvider implements ReleaseProvider
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function getReleases(Package $package)
    {
        $releases = [];
        $branches = $this->fetchBranches($package);

        foreach ($branches as $branch) {
            try {
                $version = Version::string($branch['name']);
                $releases[] = new Release($package, $version);
            } catch (\InvalidArgumentException $e) {
            }
        }

        return $releases;
    }

    /**
     * Fetches branches for provided package.
     *
     * @param Package $package
     *
     * @return array[]
     */
    private function fetchBranches(Package $package)
    {
        $organisation = $package->getOrganisation();
        $repository = $package->getName();
        $branches = $this->client->repo()->branches($organisation, $repository);

        return $branches;
    }
}
