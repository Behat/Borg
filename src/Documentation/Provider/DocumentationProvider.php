<?php

namespace Behat\Borg\Documentation\Provider;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Documentation;

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
