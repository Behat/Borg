<?php

namespace Behat\Borg\Documentation;

/**
 * Provides all available documentation.
 */
interface DocumentationProvider
{
    /**
     * @return Documentation[]
     */
    public function getAllDocumentation();
}
