<?php

namespace Behat\Borg\Documentation\Publisher\Strategy;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\Publisher\DocumentationPublisher;

/**
 * Allows publishing of new or outdated documentation only.
 */
final class RefreshablePublishingStrategy implements PublishingStrategy
{
    private $publisher;

    /**
     * Initializes strategy.
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
    public function isSatisfiedByDocumentation(Documentation $documentation)
    {
        $anId = $documentation->getId();

        if (!$this->publisher->hasPublishedDocumentation($anId)) {
            return true;
        }

        $publishedDocumentation = $this->publisher->getPublishedDocumentation($anId);

        if ($publishedDocumentation->getDocumentationTime() < $documentation->getTime()) {
            return true;
        }

        return false;
    }
}
