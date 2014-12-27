<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Documentation;
use DateTimeImmutable;

final class FakeBuilder implements Builder
{
    public function buildDocumentation(Documentation $documentation)
    {
        return new FakeBuiltDocumentation($documentation, new DateTimeImmutable());
    }
}
