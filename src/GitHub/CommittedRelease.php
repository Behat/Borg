<?php

namespace Behat\Borg\GitHub;

use Behat\Borg\Package\Release;

/**
 * Represents GitHub committed release.
 */
final class CommittedRelease
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
}
