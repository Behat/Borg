<?php

namespace Behat\Borg\Package\Finder;

use Behat\Borg\Release\Downloader\Download;

/**
 * Compound package finder.
 */
final class CompoundFinder implements PackageFinder
{
    /**
     * @var PackageFinder[]
     */
    private $finders;

    /**
     * Initializes finder.
     *
     * @param PackageFinder[] $finders
     */
    public function __construct(array $finders)
    {
        $this->finders = $finders;
    }

    /**
     * {@inheritdoc}
     */
    public function find(Download $download)
    {
        foreach ($this->finders as $finder) {
            if ($package = $finder->find($download)) {
                return $package;
            }
        }

        return null;
    }
}
