<?php

namespace Behat\Borg\Package;

/**
 * Represents a software package.
 */
interface Package
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
