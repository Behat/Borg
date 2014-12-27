<?php

namespace Behat\Borg\Documentation\Publisher;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Documentation publisher that simply moves built docs into a public directory.
 */
final class DocumentationDirectoryPublisher implements DocumentationPublisher
{
    private $publishPath;

    /**
     * Initialises publisher.
     *
     * @param string $publishPath
     */
    public function __construct($publishPath)
    {
        $this->publishPath = $publishPath;
    }

    /**
     * {@inheritdoc}
     */
    public function publishDocumentation(BuiltDocumentation $builtDocumentation)
    {
        $path = "{$this->publishPath}/{$builtDocumentation->getId()}";
        (new Filesystem())->mirror($builtDocumentation->getBuildPath(), $path);

        $publishedDocumentation = PublishedDocumentation::publish($builtDocumentation, $path);
        file_put_contents("{$path}/publish.meta", serialize($publishedDocumentation));

        return $publishedDocumentation;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPublishedDocumentation(DocumentationId $anId)
    {
        return file_exists("{$this->publishPath}/{$anId}/publish.meta");
    }

    /**
     * {@inheritdoc}
     */
    public function getPublishedDocumentation(DocumentationId $anId)
    {
        if (!$this->hasPublishedDocumentation($anId)) {
            throw new \InvalidArgumentException("Documentation {$anId} was not published.");
        }

        return unserialize(file_get_contents("{$this->publishPath}/{$anId}/publish.meta"));
    }
}
