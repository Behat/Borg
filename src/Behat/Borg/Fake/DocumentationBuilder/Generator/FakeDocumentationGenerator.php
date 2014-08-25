<?php

namespace Behat\Borg\Fake\DocumentationBuilder\Generator;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\DocumentationBuilder\Generator\DocumentationGenerator;
use Behat\Borg\Fake\DocumentationBuilder\FakeBuiltDocumentation;
use DateTimeImmutable;

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
