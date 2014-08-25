<?php

namespace Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\DocumentationId;

/**
 * Represents built documentation.
 */
interface BuiltDocumentation
{
    /**
     * @return DocumentationId
     */
    public function getId();

    /**
     * Returns documentation build path.
     *
     * @return string
     */
    public function getBuildPath();

    /**
     * Returns path to the built documentation index file.
     *
     * @return string
     */
    public function getIndexPath();
}
