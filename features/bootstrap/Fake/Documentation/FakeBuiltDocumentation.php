<?php

namespace Fake\Documentation;

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

    public function documentationId()
    {
        return $this->documentation->documentationId();
    }

    public function buildPath()
    {
        return '/tmp';
    }

    public function getIndexPath()
    {
        return '/tmp/index.html';
    }

    public function builtAt()
    {
        return $this->buildTime;
    }

    public function documentedAt()
    {
        return $this->documentation->documentedAt();
    }
}
