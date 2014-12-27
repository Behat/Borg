<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Builder\DocumentationBuilder;
use Behat\Borg\Documentation\Documentation;
use DateTimeImmutable;

final class FakeDocumentationBuilder implements DocumentationBuilder
{
    public function buildDocumentation(Documentation $documentation)
    {
        return new FakeBuiltDocumentation($documentation, new DateTimeImmutable());
    }
}
