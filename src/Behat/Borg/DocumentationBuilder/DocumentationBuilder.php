<?php

namespace Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;

/**
 * Builds raw documentation into built documentation.
 */
interface DocumentationBuilder
{
    /**
     * Builds provided documentation.
     *
     * @param Documentation $documentation
     *
     * @return null|BuiltDocumentation
     */
    public function build(Documentation $documentation);
}
