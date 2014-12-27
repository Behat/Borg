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
     * Initializes documentation id.
     *
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
        return $this->release->getVersion()->getMinor();
    }

    /**
     * @return Release
     */
    public function getRelease()
    {
        return $this->release;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf(
            '%s/%s', $this->release->getPackage(), $this->release->getVersion()->getMinor()
        );
    }
}
