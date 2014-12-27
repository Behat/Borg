<?php

namespace Behat\Borg\Documentation\Builder;

use Behat\Borg\Documentation\Documentation;

/**
 * Builds raw documentation.
 */
interface DocumentationBuilder
{
    /**
     * Builds provided documentation.
     *
     * @param Documentation $documentation
     *
     * @return BuiltDocumentation
     */
    public function buildDocumentation(Documentation $documentation);
}
