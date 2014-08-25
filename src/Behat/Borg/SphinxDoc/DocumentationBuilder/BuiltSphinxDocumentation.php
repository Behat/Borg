<?php

namespace Behat\Borg\SphinxDoc\DocumentationBuilder;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
use DateTimeImmutable;

/**
 * Represents built Sphinx (*.rst) documentation.
 */
final class BuiltSphinxDocumentation implements BuiltDocumentation
{
    private $anId;
    private $buildPath;

    /**
     * @param DocumentationId $anId
     * @param string          $buildPath
     */
    public function __construct(DocumentationId $anId, $buildPath)
    {
        $this->anId = $anId;
        $this->buildPath = $buildPath;
        $this->buildTime = new DateTimeImmutable();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->anId;
    }

    /**
     * {@inheritdoc}
     */
    public function getBuildPath()
    {
        return $this->buildPath;
    }

    /**
     * {@inheritdoc}
     */
    public function getIndexPath()
    {
        return $this->getBuildPath() . '/index.html';
    }

    /**
     * {@inheritdoc}
     */
    public function getBuildTime()
    {
        return $this->buildTime;
    }
}
