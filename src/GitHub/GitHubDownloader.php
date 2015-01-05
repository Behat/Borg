<?php

namespace Behat\Borg\GitHub;

use Behat\Borg\GitHub\Exception\ReleaseWasNotFound;
use Behat\Borg\Release\Downloader\Downloader;
use Behat\Borg\Release\Repository;
use Behat\Borg\Release\Release;
use DateTimeImmutable;
use Github\Client;
use Github\Exception\RuntimeException;
use Github\HttpClient\Message\ResponseMediator;
use Symfony\Component\Filesystem\Filesystem;

final class GitHubDownloader implements Downloader
{
    private $client;
    private $filesystem;
    private $downloadPath;

    public function __construct(Client $client, $downloadPath)
    {
        $this->client = $client;
        $this->downloadPath = $downloadPath;
        $this->filesystem = new Filesystem();
    }

    /**
     * {@inheritdoc}
     */
    public function download(Release $release)
    {
        try {
            $commit = $this->fetchLatestCommit($release);
        } catch (RuntimeException $e) {
            throw new ReleaseWasNotFound("Requested release `{$release}` was not found on GitHub.", 0, $e);
        }

        $download = new GitHubDownload($release, $commit, $this->getDownloadPath($release));

        if ($this->releaseIsAlreadyAtCommit($release, $commit)) {
            return $download;
        }

        $this->downloadReleaseAtCommit($release, $commit);

        return $download;
    }

    private function fetchLatestCommit(Release $release)
    {
        $organisation = $release->getRepository()->getOrganisationName();
        $repository = $release->getRepository()->getName();
        $version = (string)$release->getVersion();

        $commit = $this->client->repo()->commits()->all($organisation, $repository, array('sha' => $version))[0];
        $time = new DateTimeImmutable($commit['commit']['author']['date']);

        return Commit::committedWithShaAtTime($commit['sha'], $time);
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
        $downloadPath = $this->getDownloadPath($release);

        if (file_exists($downloadPath)) {
            $this->filesystem->remove($downloadPath);
        }

        $this->filesystem->mkdir($downloadPath);
        $this->downloadArchive($release, $commit, $downloadPath);
        file_put_contents($this->getCommitMetaPath($release), serialize($commit));
    }

    private function downloadArchive(Release $release, Commit $commit, $releasePath)
    {
        $archivePath = $this->getArchivePath($release->getRepository(), $commit);
        $content = ResponseMediator::getContent(
            $this->client->getHttpClient()->get(
                'repos/' .
                rawurlencode($release->getRepository()->getOrganisationName()) .
                '/' .
                rawurlencode($release->getRepository()->getName()) .
                '/zipball/' .
                $commit->getSha()
            )
        );
        file_put_contents($archivePath, $content);

        $archive = new \ZipArchive();
        $archive->open($archivePath);
        $archive->extractTo($this->getOrganisationPath($release->getRepository()));
        $archive->close();

        $unzippedPath = $this->getUnzippedCommitPath($release->getRepository(), $commit);
        $this->filesystem->rename($unzippedPath, $releasePath, true);
        $this->filesystem->remove($archivePath);
    }

    private function getDownloadPath(Release $release)
    {
        return "{$this->downloadPath}/{$release}";
    }

    private function getCommitMetaPath(Release $release)
    {
        return $this->getDownloadPath($release) . '/commit.meta';
    }

    private function getArchivePath(Repository $package, Commit $commit)
    {
        return $this->downloadPath . '/' . $package . '/' . $commit->getSha() . '.zip';
    }

    private function getOrganisationPath(Repository $package)
    {
        return $this->downloadPath . '/' . $package->getOrganisationName();
    }

    private function getUnzippedCommitPath(Repository $package, Commit $commit)
    {
        $shortSha = mb_substr($commit->getSha(), 0, 7);
        $organisation = $package->getOrganisationName();
        $repository = $package->getName();

        return $this->getOrganisationPath($package) . '/' . "{$organisation}-{$repository}-{$shortSha}";
    }
}
