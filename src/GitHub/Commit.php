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

    public static function committedWithShaAt($sha, DateTimeImmutable $time)
    {
        $commit = new Commit();
        $commit->sha = $sha;
        $commit->time = $time;

        return $commit;
    }

    /**
     * @return string
     */
    public function getSha()
    {
        return $this->sha;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getTime()
    {
        return $this->time;
    }

    private function __construct() { }
}
