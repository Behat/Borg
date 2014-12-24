<?php

namespace Behat\Borg\GitHub;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Provider\DocumentationProvider;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Behat\Borg\SphinxDoc\RstDocumentationSource;
use Github\Client;

/**
 * Provides documentation source using GitHub.
 */
final class GitHubDocumentationProvider implements DocumentationProvider
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var array[]
     */
    private $watchedRepositories;

    /**
     * @param Client $client
     * @param array  $watchedRepositories
     */
    public function __construct(Client $client, array $watchedRepositories)
    {
        $this->client = $client;
        $this->watchedRepositories = $watchedRepositories;
    }

    /**
     * {@inheritdoc}
     */
    public function findDocumentationById(DocumentationId $anId)
    {
        if (!$anId instanceof ReleaseDocumentationId) {
            throw new \InvalidArgumentException(
                'GitHubDocumentationProvider works only with ReleaseDocumentationId.'
            );
        }

        return $this->getReleaseDocumentation($this->getCommittedRelease($anId->getRelease()));
    }

    /**
     * {@inheritdoc}
     */
    public function getAllDocumentation()
    {
        $documentation = [];

        foreach ($this->watchedRepositories as $repositoryName) {
            list($organisation, $repository) = explode('/', $repositoryName);

            foreach ($this->getCommittedReleases($organisation, $repository) as $release) {
                $documentation[] = $this->getReleaseDocumentation($release);
            }
        }

        return $documentation;
    }

    private function getReleaseDocumentation(CommittedRelease $committedRelease)
    {
        return new Documentation(
            new ReleaseDocumentationId($committedRelease->getRelease()),
            RstDocumentationSource::atPath('_NO_FILE'),
            $committedRelease->getCommit()->getTime()
        );
    }

    private function getCommittedReleases($organisation, $repository)
    {
        $branches = $this->client->api('repo')->branches($organisation, $repository);
        $releases = [];

        foreach ($branches as $branch) {
            $package = GitHubPackage::named($organisation . '/' . $repository);
            $version = Version::string($branch['name']);
            $release = new Release($package, $version);

            $releases[] = $this->getCommittedRelease($release);
        }

        return $releases;
    }

    private function getCommittedRelease(Release $release)
    {
        return new CommittedRelease($release, $this->getCommit($release));
    }

    private function getCommit(Release $release)
    {
        $commit = $this->client->api('repo')->commits()->all(
            $release->getPackage()->getOrganisation(),
            $release->getPackage()->getName(),
            array('sha' => (string)$release->getVersion())
        )[0];

        $date = new \DateTimeImmutable($commit['commit']['author']['date']);

        return Commit::committedWithShaAt($commit['sha'], $date);
    }
}
