<?php

namespace Behat\Borg\Integration\Documentation\Release;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Release\Package;
use Behat\Borg\Release\Version;

/**
 * Package-based DocumentationId factory.
 */
final class DocumentationIdFactory
{
    /**
     * Creates new DocumentationId using provided package and version.
     *
     * @param Package $package
     * @param Version $version
     *
     * @return DocumentationId
     */
    public function createDocumentationId(Package $package, Version $version)
    {
        return new DocumentationId((string)$package, $this->versionString($version));
    }

    /**
     * Converts provided Version VO into the version string.
     *
     * @param Version $version
     *
     * @return string
     */
    private function versionString(Version $version)
    {
        if ($version->isBranch()) {
            return $version->branchName();
        }

        if (!$version->isStable()) {
            return 'v' . $version->patch();
        }

        return 'v' . $version->minor();
    }
}
