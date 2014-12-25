<?php

namespace Behat\Borg\GitHub;

use Behat\Borg\Package\Downloader\DownloadedRelease;
use Behat\Borg\Package\Release;
use DateTimeImmutable;

/**
 * Represents GitHub committed release.
 */
final class CommittedRelease implements DownloadedRelease
{
    private $release;
    private $commit;
    private $path;

    public function __construct(Release $release, Commit $commit, $path)
    {
        $this->release = $release;
        $this->commit = $commit;
        $this->path = $path;
    }

    /**
     * @return Release
     */
    public function getRelease()
    {
        return $this->release;
    }

    /**
     * @return Commit
     */
    public function getCommit()
    {
        return $this->commit;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getReleaseTime()
    {
        return $this->commit->getTime();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $relativePath
     *
     * @return Boolean
     */
    public function hasFile($relativePath)
    {
        return file_exists($this->path . '/' . $relativePath);
    }
}
