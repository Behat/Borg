<?php

namespace Behat\Borg\Package;

/**
 * Represents a software package.
 */
interface Package
{
    const PACKAGE_NAME_REGEX = '#^[A-Za-z0-9][A-Za-z0-9_.-]*/[A-Za-z0-9][A-Za-z0-9_.-]*$#u';

    /**
     * Returns package organisation name.
     *
     * @return string
     */
    public function getOrganisationName();

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
