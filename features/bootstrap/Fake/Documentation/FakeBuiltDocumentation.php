<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Documentation;
use DateTimeImmutable;

/**
 * Fake implementation of built documentation.
 */
final class FakeBuiltDocumentation implements \Behat\Borg\Documentation\Builder\BuiltDocumentation
{
    private $documentation;
    private $buildTime;

    public function __construct(Documentation $documentation, DateTimeImmutable $buildTime)
    {
        $this->documentation = $documentation;
        $this->buildTime = $buildTime;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->documentation->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getBuildPath()
    {
        return '/tmp';
    }

    /**
     * {@inheritdoc}
     */
    public function getIndexPath()
    {
        return '/tmp/index.html';
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
        return $this->documentation->getTime();
    }
}
