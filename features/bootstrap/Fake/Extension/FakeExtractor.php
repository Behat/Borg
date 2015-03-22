<?php

namespace Fake\Extension;

use Behat\Borg\Extension\Extractor\Extractor;
use Behat\Borg\Release\Package;

final class FakeExtractor implements Extractor
{
    public function extract(Package $package)
    {
        if ($package instanceof FakeExtensionPackage) {
            return $package->extension();
        }

        return null;
    }
}
