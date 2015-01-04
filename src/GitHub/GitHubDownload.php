<?php

namespace Behat\Borg\GitHub;

use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Release;

/**
 * Represents downloaded GitHub release.
 */
final class GitHubDownload implements Download
{
    private $release;
    private $commit;
    private $path;

    /**
     * Initializes downloaded release.
     *
     * @param Release $release
     * @param Commit  $commit
     * @param string  $path
     */
    public function __construct(Release $release, Commit $commit, $path)
    {
        $this->release = $release;
        $this->commit = $commit;
        $this->path = $path;
    }

    /**
     * Returns the commit.
     *
     * @return Commit
     */
    public function getCommit()
    {
        return $this->commit;
    }

    /**
     * {@inheritdoc}
     */
    public function getRelease()
    {
        return $this->release;
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
        return $this->release->getVersion();
    }

    /**
     * {@inheritdoc}
     */
    public function getReleaseTime()
    {
        return $this->commit->getTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function hasFile($relativePath)
    {
        return file_exists($this->path . '/' . $relativePath);
    }
}
