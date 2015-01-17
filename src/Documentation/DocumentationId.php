<?php

namespace Behat\Borg\Documentation;

/**
 * Represents a unique way to identify any documentation.
 */
interface DocumentationId
{
    /**
     * Returns documented project name.
     *
     * @return string
     */
    public function projectName();

    /**
     * Returns documentation version string.
     *
     * @return string
     */
    public function versionString();

    /**
     * Returns unique documentation ID string.
     *
     * @return string
     */
    public function __toString();
}
