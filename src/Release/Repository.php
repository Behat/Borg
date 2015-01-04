<?php

namespace Behat\Borg\Release;

/**
 * Represents software package.
 */
interface Repository
{
    /**
     * Returns package organisation name.
     *
     * @return string
     */
    public function getOrganisation();

    /**
     * Returns package name.
     *
     * @return string
     */
    public function getName();

    /**
     * Returns string representation of package.
     *
     * @return string
     */
    public function __toString();
}
