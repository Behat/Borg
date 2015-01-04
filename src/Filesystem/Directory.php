<?php

namespace Behat\Borg\Filesystem;

use Behat\Borg\Filesystem\Exception\FileNotFound;

/**
 * Represents a directory of files.
 */
interface Directory
{
    /**
     * Returns path to downloaded release.
     *
     * @return string
     */
    public function getPath();

    /**
     * Checks if downloaded release has provided file.
     *
     * @param string $relativePath
     *
     * @return Boolean
     */
    public function hasFile($relativePath);

    /**
     * Returns absolute path to the file of relative path.
     *
     * @param string $relativePath
     *
     * @return string
     *
     * @throws FileNotFound
     */
    public function getFilePath($relativePath);
}
