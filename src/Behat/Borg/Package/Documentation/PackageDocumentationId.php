<?php

namespace Behat\Borg\Package\Documentation;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Version;

final class PackageDocumentationId implements DocumentationId
{
    public function __construct(Package $package, Version $version)
    {
        // TODO: write logic here
    }
}
