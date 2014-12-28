<?php

namespace Behat\Borg\Documentation\Builder;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\Exception\BuildFailed;

/**
 * Builds raw documentation.
 */
interface Builder
{
    /**
     * Builds provided documentation.
     *
     * @param Documentation $documentation
     *
     * @return BuiltDocumentation
     *
     * @throws BuildFailed
     */
    public function build(Documentation $documentation);
}
