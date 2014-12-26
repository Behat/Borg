<?php

namespace Behat\Borg\Package\Provider;

use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;

/**
 * Provides all tracked releases.
 */
interface ReleaseProvider
{
    /**
     * Check if provider knows about given release.
     *
     * @param Release $release
     *
     * @return Boolean
     */
    public function hasRelease(Release $release);

    /**
     * Returns all available releases for provided package.
     *
     * @param Package $package
     *
     * @return Release[]
     */
    public function getReleases(Package $package);
}
