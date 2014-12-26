<?php

namespace Behat\Borg\Documentation\Listener;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Publisher\DocumentationPublisher;

final class PublishingDocumentationBuildListener implements DocumentationBuildListener
{
    private $publisher;

    public function __construct(DocumentationPublisher $publisher)
    {
        $this->publisher = $publisher;
    }

    public function documentationWasBuilt(BuiltDocumentation $builtDocumentation)
    {
        $this->publisher->publishDocumentation($builtDocumentation);
    }
}
