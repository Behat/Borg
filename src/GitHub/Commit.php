<?php

namespace Behat\Borg\GitHub;

use DateTimeImmutable;

/**
 * Represents a git commit.
 */
final class Commit
{
    private $sha;
    private $time;

    /**
     * Initializes commit.
     *
     * @param string            $sha
     * @param DateTimeImmutable $time
     *
     * @return Commit
     */
    public static function committedWithShaAtTime($sha, DateTimeImmutable $time)
    {
        $commit = new Commit();
        $commit->sha = $sha;
        $commit->time = $time;

        return $commit;
    }

    /**
     * Returns commit SHA.
     *
     * @return string
     */
    public function getSha()
    {
        return $this->sha;
    }

    /**
     * Returns commit time.
     *
     * @return DateTimeImmutable
     */
    public function getTime()
    {
        return $this->time;
    }

    private function __construct() { }
}
