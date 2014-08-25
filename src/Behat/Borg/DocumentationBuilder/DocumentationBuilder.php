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
     */
    public function build(Documentation $documentation);
}
