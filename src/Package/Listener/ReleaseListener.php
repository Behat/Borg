<?php

namespace Behat\Borg\Package\Listener;

use Behat\Borg\Package\Release;

/**
 * Listener for high-level package release events.
 */
interface ReleaseListener
{
    /**
     * Notifies listener about new release.
     *
     * @param Release $release
     */
    public function packageWasReleased(Release $release);
}
