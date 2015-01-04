<?php

namespace Behat\Borg\PackageDocumentation;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Release\Release;

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
        return strtolower(preg_replace('~(?<=\\w)([A-Z])~', '-$1', $this->release->getPackage()));
    }

    /**
     * {@inheritdoc}
     */
    public function getVersionString()
    {
        return sprintf('v%s', $this->release->getVersion()->getMinor());
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
        return sprintf('%s/%s', $this->getProjectName(), $this->getVersionString());
    }
}
