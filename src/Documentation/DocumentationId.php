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
    public function getProjectName();

    /**
     * Returns documentation version string.
     *
     * @return string
     */
    public function getVersionString();

    /**
     * Returns unique documentation ID string.
     *
     * @return string
     */
    public function __toString();
}
