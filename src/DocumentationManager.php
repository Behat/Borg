<?php

namespace Behat\Borg;

use Behat\Borg\Documentation\File\FileLocator;
use Behat\Borg\Documentation\File\PublishedFile;
use Behat\Borg\Documentation\Publisher\Publisher;

/**
 * Manages documentation by providing high-level accessor methods.
 */
final class DocumentationManager
{
    /**
     * @var Publisher
     */
    private $publisher;

    /**
     * Initialize manager.
     *
     * @param Publisher $publisher
     */
    public function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * Tries to find documentation using provided file locator.
     *
     * @param FileLocator $locator
     *
     * @return null|PublishedFile
     */
    public function findFile(FileLocator $locator)
    {
        if (!$this->publisher->hasPublished($locator->getId())) {
            return null;
        }

        $documentation = $this->publisher->getPublished($locator->getId());

        if (!$documentation->hasFile($locator->getRelativePath())) {
            return null;
        }

        return PublishedFile::publishedAtPath($documentation, $locator->getRelativePath());
    }
}
