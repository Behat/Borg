<?php

namespace Behat\Borg\Documentation\Locator;

/**
 * Represents an absolute path to a documentation file.
 */
final class LocatedFile
{
    /**
     * @var string
     */
    private $absolutePath;

    public static function atPath($absolutePath)
    {
        $file = new LocatedFile($absolutePath);
        $file->absolutePath = $absolutePath;

        return $file;
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
