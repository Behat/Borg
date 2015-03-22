<?php

namespace Behat\Borg\Integration\Extension\Composer;

use Behat\Borg\Extension\Extension;
use Behat\Borg\Extension\Extractor\Extractor;
use Behat\Borg\Integration\Release\Composer\ComposerPackage;
use Behat\Borg\Release\Package;

/**
 * Extracts extension from the composer package.
 */
final class ComposerExtractor implements Extractor
{
    /**
     * {@inheritdoc}
     */
    public function extract(Package $package)
    {
        if (!$package instanceof ComposerPackage) {
            return null;
        }

        if ('behat-extension' != $package->type()) {
            return null;
        }

        return new Extension($package->organisationName(), $package->name());
    }
}
