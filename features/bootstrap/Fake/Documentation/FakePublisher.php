<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\Publisher;

final class FakePublisher implements Publisher
{
    private $documentation;

    public function publishDocumentation(BuiltDocumentation $builtDocumentation)
    {
        $this->documentation[(string)$builtDocumentation->getId()] = $builtDocumentation;
    }

    public function hasPublishedDocumentation(DocumentationId $anId)
    {
        return isset($this->documentation['' . $anId]);
    }

    public function getPublishedDocumentation(DocumentationId $anId)
    {
        return $this->documentation[(string)$anId];
    }
}
