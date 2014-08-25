<?php

namespace Behat\Borg\Package\Documentation;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Version;

final class PackageDocumentationId implements DocumentationId
{
    private $package;
    private $version;

    public function __construct(Package $package, Version $version)
    {
        $this->package = $package;
        $this->version = $version;
    }

    public function __toString()
    {
        return $this->package->getName() . '/v' . $this->version;
    }
}
