<?php

namespace Behat\Borg\GitHub;

use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\ReleaseDownloader;
use Github\Client;
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

        $commit = $this->getLatestCommit($release);
        $committedRelease = new CommittedRelease($release, $commit);

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
        // TODO: Implement downloadAllReleases() method.
    }

    private function getLatestCommit(Release $release)
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

    private function getReleasePath(Release $release)
    {
        return "{$this->downloadPath}/{$release}";
    }

    private function getCommitMetaPath(Release $release)
    {
        return "{$this->getReleasePath($release)}/commit.meta";
    }

    private function getArchiveUrl(Package $package, Commit $commit)
    {
        return "https://github.com/{$package}/archive/{$commit->getSha()}.zip";
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
        return "{$this->getOrganisationPath($package)}/{$package->getName()}-{$commit->getSha()}";
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
        $archiveUrl = $this->getArchiveUrl($release->getPackage(), $commit);
        $archivePath = $this->getArchivePath($release->getPackage(), $commit);
        file_put_contents($archivePath, file_get_contents($archiveUrl));

        $archive = new \ZipArchive();
        $archive->open($archivePath);
        $archive->extractTo($this->getOrganisationPath($release->getPackage()));
        $archive->close();

        $unzippedPath = $this->getUnzippedCommitPath($release->getPackage(), $commit);
        $this->filesystem->rename($unzippedPath, $releasePath, true);
        $this->filesystem->remove($archivePath);
    }
}
