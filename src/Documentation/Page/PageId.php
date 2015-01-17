<?php

namespace Behat\Borg\Documentation\Page;

/**
 * Represents a documentation page ID.
 */
final class PageId
{
    /**
     * @var string
     */
    private $path;

    /**
     * Initializes ID.
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Returns relative path to the page file.
     *
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->path;
    }
}
