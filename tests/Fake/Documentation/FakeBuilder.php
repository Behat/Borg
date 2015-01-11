<?php

namespace tests\Behat\Borg\Fake\Documentation;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\RawDocumentation;
use DateTimeImmutable;

final class FakeBuilder implements Builder
{
    public function build(RawDocumentation $documentation)
    {
        return new FakeBuiltDocumentation($documentation, new DateTimeImmutable());
    }
}
