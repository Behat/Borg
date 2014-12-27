<?php

namespace tests\Behat\Borg\GitHub;

use Behat\Borg\GitHub\GitHubBranchReleaseProvider;
use Behat\Borg\GitHub\GitHubPackage;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Github\Client;
use PHPUnit_Framework_TestCase;

class GitHubBranchReleaseProviderTest extends PHPUnit_Framework_TestCase
{
    private $provider;

    protected function setUp()
    {
        $client = new Client();
        $client->authenticate(getenv('GITHUB_TOKEN'), null, Client::AUTH_URL_TOKEN);

        $this->provider = new GitHubBranchReleaseProvider($client, ['Behat/docs']);
    }

    /** @test */
    function it_can_retrieve_all_releases_for_tracked_repositories()
    {
        $package = GitHubPackage::named('Behat/docs');
        $releases = $this->provider->getReleases($package);

        $this->assertContains(
            new Release($package, Version::string('v2.5')),
            $releases,
            'v2.5 release is not retrieved.',
            false,
            false
        );

        $this->assertContains(
            new Release($package, Version::string('v3.0')),
            $releases,
            'v2.5 release is not retrieved.',
            false,
            false
        );
    }

    /** @test */
    function it_ignores_branches_that_do_not_look_like_versions()
    {
        $package = GitHubPackage::named('everzet/basket-by-example');
        $releases = $this->provider->getReleases($package);

        $this->assertCount(0, $releases);
    }
}
