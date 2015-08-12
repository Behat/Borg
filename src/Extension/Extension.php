<?php

namespace Behat\Borg\Extension;

/**
 * Represents Behat extension.
 */
final class Extension
{
    /**
     * @var string
     */
    private $organisationName;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string[]
     */
    private $author;

    /**
     * Initializes extension.
     *
     * @param string $organisationName
     * @param string $name
     * @param string $description
     * @param string $author
     */
    public function __construct($organisationName, $name, $description, $author)
    {
        $this->organisationName = $organisationName;
        $this->name = $name;
        $this->description = $description;
        $this->author = $author;
    }

    /**
     * Returns organisation this extension belongs to.
     *
     * @return string
     */
    public function organisationName()
    {
        return $this->organisationName;
    }

    /**
     * Returns name of the extension.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Returns extension description.
     *
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * Returns extension author name.
     *
     * @return string
     */
    public function author()
    {
        return $this->author;
    }

    /**
     * Converts extension to string.
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->organisationName, $this->name);
    }
}
