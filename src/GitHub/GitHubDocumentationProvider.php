<?php

namespace Behat\Borg\GitHub;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationProvider;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Package;
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

        return $this->getReleaseDocumentation($anId->getRelease());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllDocumentation()
    {
        // TODO: Implement getAllDocumentation() method.
    }

    private function getReleaseDocumentation(Release $release)
    {
        return new Documentation(
            new ReleaseDocumentationId($release),
            RstDocumentationSource::atPath('_NO_FILE'),
            $this->getCommitDate($release->getPackage(), $release->getVersion())
        );
    }

    private function getCommitDate(Package $package, Version $version)
    {
        return new \DateTimeImmutable(
            $this->client->api('repo')->commits()->all(
                $package->getOrganisation(),
                $package->getName(),
                array('sha' => (string)$version)
            )[0]['commit']['author']['date']
        );
    }
}
