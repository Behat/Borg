<?php

namespace Behat\Borg\Extension\Extractor;

use Behat\Borg\Extension\Extension;
use Behat\Borg\Release\Package;

/**
 * Extracts extension from the package.
 */
interface Extractor
{
    /**
     * Attempts to extract extension from the package.
     *
     * @param Package $package
     *
     * @return null|Extension
     */
    public function extract(Package $package);
}
