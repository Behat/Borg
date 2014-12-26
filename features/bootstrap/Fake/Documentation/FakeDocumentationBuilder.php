<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Builder\DocumentationBuilder;
use Behat\Borg\Documentation\Documentation;
use DateTimeImmutable;

/**
 * It wraps documentation into FakeBuildDocumentation and returns one back.
 */
final class FakeDocumentationBuilder implements DocumentationBuilder
{
    private $buildTime;

    public function __construct()
    {
        $this->buildTime = new DateTimeImmutable();
    }

    /**
     * @param DateTimeImmutable $buildTime
     */
    public function changeBuildTime(DateTimeImmutable $buildTime)
    {
        $this->buildTime = $buildTime;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getLastBuildTime()
    {
        return $this->buildTime;
    }

    /**
     * {@inheritdoc}
     */
    public function build(Documentation $documentation)
    {
        return new FakeBuiltDocumentation($documentation, $this->buildTime);
    }
}