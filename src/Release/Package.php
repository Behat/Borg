<?php

namespace Behat\Borg\Release;

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
    public function organisationName();

    /**
     * Returns package name.
     *
     * @return string
     */
    public function name();

    /**
     * Returns string representation of package.
     *
     * @return string
     */
    public function __toString();
}
