<?php

namespace Behat\Borg\Documentation\Builder\BuildSpecification;

use Behat\Borg\Documentation\Documentation;

/**
 * Defines when to build specific documents.
 */
interface DocumentationBuildSpecification
{
    /**
     * Checks if provided documentation should be built.
     *
     * @param Documentation $documentation
     *
     * @return Boolean
     */
    public function isSatisfiedByDocumentation(Documentation $documentation);
}
