<?php

namespace Behat\Borg\Integration\Documentation\Filesystem;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Publisher\Publisher;
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
        $buildPath = $builtDocumentation->path();
        $publishPath = "{$this->publishPath}/{$builtDocumentation->documentationId()}";
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
