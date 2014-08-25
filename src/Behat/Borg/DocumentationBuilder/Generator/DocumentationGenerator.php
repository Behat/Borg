<?php

namespace Behat\Borg\DocumentationBuilder\Generator;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;

/**
 * Generates documentation using some generator.
 */
interface DocumentationGenerator
{
    /**
     * Generates provided documentation.
     *
     * @param Documentation $documentation
     *
     * @return null|BuiltDocumentation
     */
    public function generate(Documentation $documentation);
}
