<?php

namespace Behat\Borg\Documentation\Builder\Generator;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
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
