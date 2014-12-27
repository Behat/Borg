<?php

namespace Behat\Borg\Documentation\Listener;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Publisher\DocumentationPublisher;

/**
 * Publishes documentation after successful build.
 */
final class PublishingDocumentationBuildListener implements DocumentationBuildListener
{
    /**
     * @var DocumentationPublisher
     */
    private $publisher;

    /**
     * Initializes listener.
     *
     * @param DocumentationPublisher $publisher
     */
    public function __construct(DocumentationPublisher $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * {@inheritdoc}
     */
    public function documentationWasBuilt(BuiltDocumentation $builtDocumentation)
    {
        $this->publisher->publishDocumentation($builtDocumentation);
    }
}
