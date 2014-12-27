<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Documentation;
use DateTimeImmutable;

final class FakeBuiltDocumentation implements BuiltDocumentation
{
    private $documentation;
    private $buildTime;

    public function __construct(Documentation $documentation, DateTimeImmutable $buildTime)
    {
        $this->documentation = $documentation;
        $this->buildTime = $buildTime;
    }

    public function getId()
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
