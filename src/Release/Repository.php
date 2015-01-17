<?php

namespace Behat\Borg\Release;

/**
 * Represents software repository.
 */
interface Repository
{
    /**
     * Returns repository organisation name.
     *
     * @return string
     */
    public function organisationName();

    /**
     * Returns repository name.
     *
     * @return string
     */
    public function name();

    /**
     * Returns string representation of repository.
     *
     * @return string
     */
    public function __toString();
}
