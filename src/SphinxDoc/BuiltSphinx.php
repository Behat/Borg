<?php

namespace Behat\Borg\SphinxDoc;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use DateTimeImmutable;

/**
 * Represents built Sphinx (*.rst) documentation.
 */
final class BuiltSphinx implements BuiltDocumentation
{
    private $anId;
    private $buildPath;
    private $buildTime;
    private $documentationTime;

    /**
     * @param DocumentationId   $anId
     * @param DateTimeImmutable $documentationTime
     * @param DateTimeImmutable $buildTime
     * @param string            $buildPath
     */
    public function __construct(
        DocumentationId $anId,
        DateTimeImmutable $documentationTime,
        DateTimeImmutable $buildTime,
        $buildPath
    ) {
        $this->anId = $anId;
        $this->documentationTime = $documentationTime;
        $this->buildTime = $buildTime;
        $this->buildPath = $buildPath;
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
