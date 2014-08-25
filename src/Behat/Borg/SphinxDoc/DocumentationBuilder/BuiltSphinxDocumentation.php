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
     * @var \DateTimeImmutable
     */
    private $documentationTime;

    /**
     * @param DocumentationId   $anId
     * @param DateTimeImmutable $documentationTime
     * @param string            $buildPath
     */
    public function __construct(
        DocumentationId $anId,
        DateTimeImmutable $documentationTime,
        $buildPath
    ) {
        $this->anId = $anId;
        $this->documentationTime = $documentationTime;
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

    /**
     * {@inheritdoc}
     */
    public function getDocumentationTime()
    {
        return $this->documentationTime;
    }
}
