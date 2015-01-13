<?php

namespace Behat\Borg\Documentation\Builder;

use Behat\Borg\Documentation\RawDocumentation;
use Behat\Borg\Documentation\Exception\BuildFailed;

/**
 * Builds raw documentation.
 */
interface Builder
{
    /**
     * Builds provided documentation.
     *
     * @param RawDocumentation $documentation
     *
     * @return BuiltDocumentation
     *
     * @throws BuildFailed
     */
    public function build(RawDocumentation $documentation);
}
