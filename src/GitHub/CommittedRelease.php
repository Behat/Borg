<?php

namespace Behat\Borg\GitHub;

use Behat\Borg\Package\DownloadedRelease;
use Behat\Borg\Package\Release;
use DateTimeImmutable;

/**
 * Represents GitHub committed release.
 */
final class CommittedRelease implements DownloadedRelease
{
    private $release;
    private $commit;

    public function __construct(Release $release, Commit $commit)
    {
        $this->release = $release;
        $this->commit = $commit;
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
}
