<?php

namespace Behat\Borg\Documentation\Publisher;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;

/**
 * Publishes built documentation.
 */
interface Publisher
{
    /**
     * Publishes provided built documentation.
     *
     * @param BuiltDocumentation $builtDocumentation
     *
     * @return PublishedDocumentation
     */
    public function publish(BuiltDocumentation $builtDocumentation);
}
