<?php

namespace Fake\Extension;

use Behat\Borg\Extension\Extractor\Extractor;
use Behat\Borg\Package\Package;

final class FakeExtractor implements Extractor
{
    public function extract(Package $package)
    {
        if ($package instanceof FakeExtension) {
            return $package;
        }

        return null;
    }
}
