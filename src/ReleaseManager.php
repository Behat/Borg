<?php

namespace Behat\Borg;

use Behat\Borg\Release\Listener\ReleaseListener;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\Repository;
use Behat\Borg\Release\Version;

/**
 * Manages package releases.
 */
final class ReleaseManager
{
    /**
     * @var ReleaseListener[]
     */
    private $listeners = [];

    /**
     * Registers new listener.
     *
     * @param ReleaseListener $listener
     */
    public function registerListener(ReleaseListener $listener)
    {
        $this->listeners[] = $listener;
    }

    /**
     * Release provided package release.
     *
     * @param Repository $repository
     * @param Version    $version
     */
    public function release(Repository $repository, Version $version)
    {
        $release = new Release($repository, $version);

        foreach ($this->listeners as $listener) {
            $listener->releaseReleased($release);
        }
    }
}
