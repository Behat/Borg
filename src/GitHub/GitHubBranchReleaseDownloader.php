<?php

namespace Behat\Borg\GitHub;

use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\ReleaseDownloader;
use Behat\Borg\Package\Version;
use Github\Client;
use Github\HttpClient\Message\ResponseMediator;
use Symfony\Component\Filesystem\Filesystem;

final class GitHubBranchReleaseDownloader implements ReleaseDownloader
{
    private $client;
    private $filesystem;
    private $downloadPath;
    private $trackedRepositories;

    public function __construct(Client $client, $downloadPath, array $trackedRepositories)
    {
        $this->client = $client;
        $this->filesystem = new Filesystem();
        $this->downloadPath = $downloadPath;
        $this->trackedRepositories = $trackedRepositories;
    }

    /**
     * {@inheritdoc}
     */
    public function downloadRelease(Release $release)
    {
        if (!in_array((string) $release->getPackage(), $this->trackedRepositories)) {
            throw new \InvalidArgumentException("Trying to download untracked package.");
        }

        $commit = $this->fetchLatestCommit($release);
        $committedRelease = new CommittedRelease($release, $commit, $this->getReleasePath($release));

        if ($this->releaseIsAlreadyAtCommit($release, $commit)) {
            return $committedRelease;
        }

        $this->downloadReleaseAtCommit($release, $commit);

        return $committedRelease;
    }

    /**
     * {@inheritdoc}
     */
    public function downloadAllReleases()
    {
        $documentation = [];

        foreach ($this->trackedRepositories as $repositoryName) {
            $package = GitHubPackage::named($repositoryName);

            foreach ($this->fetchPackageReleases($package) as $release) {
                $documentation[] = $this->downloadRelease($release);
            }
        }

        return $documentation;
    }

    private function fetchPackageReleases(Package $package)
    {
        $releases = [];

        $organisation = $package->getOrganisation();
        $repository = $package->getName();
        $branches = $this->client->api('repo')->branches($organisation, $repository);

        foreach ($branches as $branch) {
            $releases[] = new Release($package, Version::string($branch['name']));
        }

        return $releases;
    }

    private function fetchLatestCommit(Release $release)
    {
        $commit = $this->client->api('repo')->commits()->all(
            $release->getPackage()->getOrganisation(),
            $release->getPackage()->getName(),
            array('sha' => (string)$release->getVersion())
        )[0];

        $date = new \DateTimeImmutable($commit['commit']['author']['date']);

        return Commit::committedWithShaAt($commit['sha'], $date);
    }

    private function releaseIsAlreadyAtCommit(Release $release, Commit $newCommit)
    {
        $commitMetaPath = $this->getCommitMetaPath($release);

        if (file_exists($commitMetaPath)) {
            $oldCommit = unserialize(file_get_contents($commitMetaPath));

            if ($oldCommit == $newCommit) {
                return true;
            }
        }

        return false;
    }

    private function downloadReleaseAtCommit(Release $release, Commit $commit)
    {
        $path = $this->getReleasePath($release);

        if (file_exists($path)) {
            $this->filesystem->remove($path);
        }

        $this->filesystem->mkdir($path);
        $this->downloadArchive($release, $commit, $path);
        file_put_contents($this->getCommitMetaPath($release), serialize($commit));
    }

    private function downloadArchive(Release $release, Commit $commit, $releasePath)
    {
        $archivePath = $this->getArchivePath($release->getPackage(), $commit);
        $content = ResponseMediator::getContent($this->client->getHttpClient()->get(
            'repos/' .
            rawurlencode($release->getPackage()->getOrganisation()) .
            '/' .
            rawurlencode($release->getPackage()->getName()) .
            '/zipball/' .
            $commit->getSha()
        ));
        file_put_contents($archivePath, $content);

        $archive = new \ZipArchive();
        $archive->open($archivePath);
        $archive->extractTo($this->getOrganisationPath($release->getPackage()));
        $archive->close();

        $unzippedPath = $this->getUnzippedCommitPath($release->getPackage(), $commit);
        $this->filesystem->rename($unzippedPath, $releasePath, true);
        $this->filesystem->remove($archivePath);
    }

    private function getReleasePath(Release $release)
    {
        return "{$this->downloadPath}/{$release}";
    }

    private function getCommitMetaPath(Release $release)
    {
        return "{$this->getReleasePath($release)}/commit.meta";
    }

    private function getArchivePath(Package $package, Commit $commit)
    {
        return "{$this->downloadPath}/{$package}/{$commit->getSha()}.zip";
    }

    private function getOrganisationPath(Package $package)
    {
        return "{$this->downloadPath}/{$package->getOrganisation()}";
    }

    private function getUnzippedCommitPath(Package $package, Commit $commit)
    {
        $shortSha = mb_substr($commit->getSha(), 0, 7);
        $organisation = $package->getOrganisation();
        $repository = $package->getName();

        return "{$this->getOrganisationPath($package)}/{$organisation}-{$repository}-{$shortSha}";
    }
}
