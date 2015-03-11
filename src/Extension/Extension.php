<?php

namespace Behat\Borg\Extension;

/**
 * Represents Behat extension.
 */
interface Extension
{
    /**
     * Returns extension organisation name.
     *
     * @return string
     */
    public function organisationName();

    /**
     * Returns extension name.
     *
     * @return string
     */
    public function name();

    /**
     * Returns string representation of extension.
     *
     * @return string
     */
    public function __toString();
}
