<?php

namespace Behat\Borg\Release\Listener;

use Behat\Borg\Release\Release;

/**
 * Listener for high-level package release events.
 */
interface ReleaseListener
{
    /**
     * Notifies listener about a new release.
     *
     * @param Release $release
     */
    public function releaseReceived(Release $release);
}
