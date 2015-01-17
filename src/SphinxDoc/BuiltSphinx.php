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
    public function documentationId()
    {
        return $this->anId;
    }

    /**
     * {@inheritdoc}
     */
    public function buildPath()
    {
        return $this->buildPath;
    }

    /**
     * {@inheritdoc}
     */
    public function indexPath()
    {
        return $this->buildPath() . '/index.html';
    }

    /**
     * {@inheritdoc}
     */
    public function builtAt()
    {
        return $this->buildTime;
    }

    /**
     * {@inheritdoc}
     */
    public function documentedAt()
    {
        return $this->documentationTime;
    }
}
