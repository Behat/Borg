<?php

namespace Behat\Borg\Package\Documentation;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Version;

/**
 * Represents a unique ID for the specific package version documentation.
 */
final class PackageDocumentationId implements DocumentationId
{
    private $package;
    private $version;

    /**
     * @param Package $package
     * @param Version $version
     */
    public function __construct(Package $package, Version $version)
    {
        $this->package = $package;
        $this->version = $version;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectName()
    {
        return $this->package->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getVersionString()
    {
        return (string)$this->version;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->package->getName() . '/v' . $this->version;
    }
}
