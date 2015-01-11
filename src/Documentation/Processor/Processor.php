<?php

namespace Behat\Borg\Documentation\Processor;

use Behat\Borg\Documentation\RawDocumentation;

/**
 * Represents a process of handling raw documentation.
 */
interface Processor
{
    /**
     * Processes provided documentation.
     *
     * @param RawDocumentation $documentation
     */
    public function process(RawDocumentation $documentation);
}
