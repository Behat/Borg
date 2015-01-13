<?php

namespace Behat\Borg\Documentation\Publisher;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
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
    public function publish(BuiltDocumentation $builtDocumentation)
    {
        $buildPath = $builtDocumentation->getBuildPath();
        $publishPath = "{$this->publishPath}/{$builtDocumentation->getDocumentationId()}";
        $publishedDocumentation = PublishedDocumentation::publish($builtDocumentation, $publishPath);

        $this->moveDocumentation($buildPath, $publishPath);

        return $publishedDocumentation;
    }

    private function moveDocumentation($buildPath, $publishPath)
    {
        $filesystem = new Filesystem();
        $filesystem->mirror($buildPath, $publishPath);
        $filesystem->remove($buildPath);
    }
}
