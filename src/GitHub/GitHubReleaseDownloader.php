<?php

namespace Behat\Borg\GitHub;

use Behat\Borg\Package\Downloader\ReleaseDownloader;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Provider\ReleaseProvider;
use Behat\Borg\Package\Release;
use Github\Client;
use Github\HttpClient\Message\ResponseMediator;
use Symfony\Component\Filesystem\Filesystem;

final class GitHubReleaseDownloader implements ReleaseDownloader
{
    private $provider;
    private $client;
    private $filesystem;
    private $downloadPath;

    public function __construct(ReleaseProvider $provider, Client $client, $downloadPath)
    {
        $this->provider = $provider;
        $this->client = $client;
        $this->downloadPath = $downloadPath;
        $this->filesystem = new Filesystem();
    }

    /**
     * {@inheritdoc}
     */
    public function downloadRelease(Release $release)
    {
        if (!$this->provider->hasRelease($release)) {
            throw new \InvalidArgumentException("Trying to download untracked release.");
        }

        $commit = $this->fetchLatestCommit($release);
        $committedRelease = new CommittedRelease(
            $release, $commit, $this->getReleasePath($release)
        );

        if ($this->releaseIsAlreadyAtCommit($release, $commit)) {
            return $committedRelease;
        }

        $this->downloadReleaseAtCommit($release, $commit);

        return $committedRelease;
    }

    private function fetchLatestCommit(Release $release)
    {
        $commit = $this->client->repo()->commits()->all(
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
        $content = ResponseMediator::getContent(
            $this->client->getHttpClient()->get(
                'repos/' .
                rawurlencode($release->getPackage()->getOrganisation()) .
                '/' .
                rawurlencode($release->getPackage()->getName()) .
                '/zipball/' .
                $commit->getSha()
            )
        );
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
