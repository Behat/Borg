<?php

namespace Behat\Borg\Documentation\Generator;

use Behat\Borg\Documentation\BuiltDocumentation;
use Behat\Borg\Documentation\Documentation;

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
