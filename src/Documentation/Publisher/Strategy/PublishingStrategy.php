<?php

namespace Behat\Borg\Documentation\Publisher\Strategy;

use Behat\Borg\Documentation\Documentation;

/**
 * Defines when to build specific documents.
 */
interface PublishingStrategy
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
