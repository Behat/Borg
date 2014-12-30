<?php

namespace Behat\Borg\Documentation\File;

use Behat\Borg\Documentation\Publisher\PublishedDocumentation;

/**
 * Represents an absolute path to a documentation file.
 */
final class PublishedFile
{
    /**
     * @var PublishedDocumentation
     */
    private $documentation;
    /**
     * @var string
     */
    private $relativePath;
    /**
     * @var string
     */
    private $absolutePath;

    public static function publishedAtPath(PublishedDocumentation $documentation, $relativePath)
    {
        $file = new PublishedFile($relativePath);
        $file->documentation = $documentation;
        $file->relativePath = $relativePath;
        $file->absolutePath = $documentation->getAbsoluteFilePath($relativePath);

        return $file;
    }

    /**
     * Returns published documentation.
     *
     * @return PublishedDocumentation
     */
    public function getDocumentation()
    {
        return $this->documentation;
    }

    /**
     * Returns relative path to a file.
     *
     * @return string
     */
    public function getRelativePath()
    {
        return $this->relativePath;
    }

    /**
     * Returns absolute path to a file.
     *
     * @return string
     */
    public function getAbsolutePath()
    {
        return $this->absolutePath;
    }

    /**
     * Returns absolute file path.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->absolutePath;
    }

    private function __construct() { }
}
