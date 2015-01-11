<?php

namespace tests\Behat\Borg\Fake\Documentation;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\RawDocumentation;
use DateTimeImmutable;

final class FakeBuiltDocumentation implements BuiltDocumentation
{
    private $documentation;
    private $buildTime;

    public function __construct(RawDocumentation $documentation, DateTimeImmutable $buildTime)
    {
        $this->documentation = $documentation;
        $this->buildTime = $buildTime;
    }

    public function getDocumentationId()
    {
        return $this->documentation->getId();
    }

    public function getBuildPath()
    {
        return '/tmp';
    }

    public function getIndexPath()
    {
        return '/tmp/index.html';
    }

    public function getBuildTime()
    {
        return $this->buildTime;
    }

    public function getDocumentationTime()
    {
        return $this->documentation->getTime();
    }
}