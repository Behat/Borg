<?php

namespace Behat\Borg\Package\Documentation;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Package\Release;

/**
 * Represents a unique ID for the specific package release documentation.
 */
final class ReleaseDocumentationId implements DocumentationId
{
    private $release;

    /**
     * @param Release $release
     */
    public function __construct(Release $release)
    {
        $this->release = $release;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectName()
    {
        return (string)$this->release->getPackage();
    }

    /**
     * {@inheritdoc}
     */
    public function getVersionString()
    {
        return (string)$this->release->getVersion();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string)$this->release;
    }
}
