<?php

namespace Behat\Borg\Extension;

/**
 * Represents Behat extension.
 */
interface Extension
{
    /**
     * Returns extension name.
     *
     * @return string
     */
    public function name();
}
