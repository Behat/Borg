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
     * {@inheritdoc}
     */
    public function hasRelease(Release $release)
    {
        $branches = $this->fetchBranches($release->getPackage());

        foreach ($branches as $branch) {
            if ($branch['name'] == $release->getVersion()) {
                return true;
            }
        }

        return false;
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
