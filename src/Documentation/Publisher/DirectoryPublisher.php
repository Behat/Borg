<?php

namespace Behat\Borg\Documentation\Publisher;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Exception\RequestedDocumentationWasNotPublished;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Documentation publisher that simply moves built docs into a public directory.
 */
final class DirectoryPublisher implements Publisher
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
        $buildPath = $builtDocumentation->getBuildPath();
        $publishPath = "{$this->publishPath}/{$builtDocumentation->getId()}";
        $publishedDocumentation = PublishedDocumentation::publish($builtDocumentation, $publishPath);

        $this->moveDocumentation($buildPath, $publishPath);
        $this->writePublishingMeta($publishPath, $publishedDocumentation);

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
            throw new RequestedDocumentationWasNotPublished("Documentation `{$anId}` was not published.");
        }

        return unserialize(file_get_contents("{$this->publishPath}/{$anId}/publish.meta"));
    }

    private function moveDocumentation($buildPath, $publishPath)
    {
        $filesystem = new Filesystem();
        $filesystem->mirror($buildPath, $publishPath);
        $filesystem->remove($buildPath);
    }

    private function writePublishingMeta($publishPath, PublishedDocumentation $documentation)
    {
        file_put_contents("{$publishPath}/publish.meta", serialize($documentation));
    }
}
