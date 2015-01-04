<?php

namespace Behat\Borg\Documentation\Publisher;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Exception\RequestedDocumentationWasNotPublished;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

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
    public function publish(BuiltDocumentation $builtDocumentation)
    {
        $buildPath = $builtDocumentation->getBuildPath();
        $publishPath = "{$this->publishPath}/{$builtDocumentation->getDocumentationId()}";
        $publishedDocumentation = PublishedDocumentation::publish($builtDocumentation, $publishPath);

        $this->moveDocumentation($buildPath, $publishPath);
        $this->writePublishingMeta($publishPath, $publishedDocumentation);

        return $publishedDocumentation;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPublished(DocumentationId $anId)
    {
        return file_exists("{$this->publishPath}/{$anId}/publish.meta");
    }

    /**
     * {@inheritdoc}
     */
    public function getPublished(DocumentationId $anId)
    {
        if (!$this->hasPublished($anId)) {
            throw new RequestedDocumentationWasNotPublished("Documentation `{$anId}` was not published.");
        }

        return unserialize(file_get_contents("{$this->publishPath}/{$anId}/publish.meta"));
    }

    /**
     * {@inheritdoc}
     */
    public function findForProject($projectName)
    {
        $documentation = [];
        foreach (Finder::create()->depth(0)->directories()->in("{$this->publishPath}/{$projectName}") as $dir) {
            $documentation[] = unserialize(file_get_contents($dir . '/publish.meta'));
        }

        return $documentation;
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
