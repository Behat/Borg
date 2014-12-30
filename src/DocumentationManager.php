<?php

namespace Behat\Borg;

use Behat\Borg\Documentation\Locator\FileLocator;
use Behat\Borg\Documentation\Locator\LocatedFile;
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
     * @return null|LocatedFile
     */
    public function findFile(FileLocator $locator)
    {
        if (!$this->publisher->hasPublished($locator->getId())) {
            return null;
        }

        $documentation = $this->publisher->getPublished($locator->getId());
        $path = $documentation->getPublishPath() . '/' . $locator->getRelativePath();

        if (!file_exists($path)) {
            return null;
        }

        return LocatedFile::atPath($path);
    }
}
