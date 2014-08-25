<?php

namespace Behat\Borg\Documentation;

/**
 * Represents a unique way to identify documentation.
 */
interface DocumentationId
{
    /**
     * Returns unique documentation ID string.
     *
     * @return string
     */
    public function __toString();
}
