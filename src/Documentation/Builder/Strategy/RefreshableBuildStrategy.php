<?php

namespace Behat\Borg\Documentation\Builder\Strategy;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\Publisher\DocumentationPublisher;

/**
 * Allows builds of new or outdated documentation only.
 */
final class RefreshableBuildStrategy implements BuildStrategy
{
    private $publisher;

    /**
     * @param DocumentationPublisher $publisher
     */
    public function __construct(DocumentationPublisher $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedByDocumentation(Documentation $documentation)
    {
        $anId = $documentation->getId();

        if (!$this->publisher->hasPublishedDocumentation($anId)) {
            return true;
        }

        $builtDocumentation = $this->publisher->getPublishedDocumentation($anId);
        if ($builtDocumentation->getDocumentationTime() < $documentation->getTime()) {
            return true;
        }

        return false;
    }
}
