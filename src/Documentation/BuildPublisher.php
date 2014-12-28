<?php

namespace Behat\Borg\Documentation;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Listener\BuildListener;
use Behat\Borg\Documentation\Publisher\Publisher;

/**
 * Publishes documentation after successful build.
 */
final class BuildPublisher implements BuildListener
{
    /**
     * @var Publisher
     */
    private $publisher;

    /**
     * Initializes listener.
     *
     * @param Publisher $publisher
     */
    public function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * {@inheritdoc}
     */
    public function documentationWasBuilt(BuiltDocumentation $builtDocumentation)
    {
        $this->publisher->publish($builtDocumentation);
    }
}
