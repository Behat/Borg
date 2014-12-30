<?php

namespace Behat\Borg\Documentation;

/**
 * Very simple string-based documentation ID.
 */
final class StringDocumentationId implements DocumentationId
{
    private $projectName;
    private $versionString;

    /**
     * Initializes an ID.
     *
     * @param string $projectName
     * @param string $versionString
     */
    public function __construct($projectName, $versionString)
    {
        $this->projectName = $projectName;
        $this->versionString = $versionString;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * {@inheritdoc}
     */
    public function getVersionString()
    {
        return $this->versionString;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "{$this->projectName}/{$this->versionString}";
    }
}
