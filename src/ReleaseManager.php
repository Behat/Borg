<?php

namespace Behat\Borg;

use Behat\Borg\Package\Listener\ReleaseListener;
use Behat\Borg\Package\Release;

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
     * @param Release $release
     */
    public function release(Release $release)
    {
        foreach ($this->listeners as $listener) {
            $listener->packageWasReleased($release);
        }
    }
}