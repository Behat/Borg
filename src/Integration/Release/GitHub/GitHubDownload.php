<?php

namespace Behat\Borg\Integration\Release\GitHub;

use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Exception\FileNotFound;
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
    public function commit()
    {
        return $this->commit;
    }

    /**
     * {@inheritdoc}
     */
    public function version()
    {
        return $this->release->version();
    }

    /**
     * {@inheritdoc}
     */
    public function releasedAt()
    {
        return $this->commit->committedAt();
    }

    /**
     * {@inheritdoc}
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function hasFile($relativePath)
    {
        return file_exists($this->path() . '/' . $relativePath);
    }

    /**
     * {@inheritdoc}
     */
    public function filePath($relativePath)
    {
        if (!$this->hasFile($relativePath)) {
            throw new FileNotFound(
                "Requested file `{$relativePath}` is not found in downloaded folder."
            );
        }

        return $this->path() . '/' . $relativePath;
    }
}
