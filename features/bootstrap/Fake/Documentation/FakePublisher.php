<?php

namespace Fake\Documentation;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\Publisher;

final class FakePublisher implements Publisher
{
    private $documentation;

    public function publish(BuiltDocumentation $builtDocumentation)
    {
        $this->documentation[(string)$builtDocumentation->getDocumentationId()] = $builtDocumentation;
    }

    public function hasPublished(DocumentationId $anId)
    {
        return isset($this->documentation['' . $anId]);
    }

    public function getPublished(DocumentationId $anId)
    {
        return $this->documentation[(string)$anId];
    }
}
