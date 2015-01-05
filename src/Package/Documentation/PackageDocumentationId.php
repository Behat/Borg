<?php

namespace Behat\Borg\Package\Documentation;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Release\Version;

/**
 * Links documentation to a specific package.
 */
final class PackageDocumentationId implements DocumentationId
{
    /**
     * @var Package
     */
    private $package;
    /**
     * @var Version
     */
    private $version;

    /**
     * Initializes ID.
     *
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
        return (string)$this->package;
    }

    /**
     * {@inheritdoc}
     */
    public function getVersionString()
    {
        if (!$this->version->isStable()) {
            return 'v' . $this->version->getPatch();
        }

        return 'v' . $this->version->getMinor();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getProjectName() . '/' . $this->getVersionString();
    }
}
