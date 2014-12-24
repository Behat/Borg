<?php

namespace Fake\Documentation\Generator;

use Behat\Borg\Documentation\Builder\Generator\DocumentationGenerator;
use Behat\Borg\Documentation\Documentation;
use DateTimeImmutable;
use Fake\Documentation\FakeBuiltDocumentation;

/**
 * It wraps documentation into FakeBuildDocumentation and returns one back.
 */
final class FakeDocumentationGenerator implements DocumentationGenerator
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
    public function generate(Documentation $documentation)
    {
        return new FakeBuiltDocumentation($documentation, $this->buildTime);
    }
}
