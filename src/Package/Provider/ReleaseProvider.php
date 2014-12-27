<?php

namespace Behat\Borg\Package\Provider;

use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;

/**
 * Provides releases for provided package.
 */
interface ReleaseProvider
{
    /**
     * Returns all available releases for provided package.
     *
     * @param Package $package
     *
     * @return Release[]
     */
    public function getReleases(Package $package);
}
