<?php

namespace Behat\Borg\Documentation;

/**
 * Very simple project documentation ID.
 */
final class ProjectDocumentationId implements DocumentationId
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
    public function projectName()
    {
        return $this->projectName;
    }

    /**
     * {@inheritdoc}
     */
    public function versionString()
    {
        return $this->versionString;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->projectName . '/' . $this->versionString;
    }
}
