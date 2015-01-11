<?php

namespace tests\Behat\Borg\Fake\Documentation;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Publisher\Publisher;

final class FakePublisher implements Publisher
{
    private $documentation;

    public function publish(BuiltDocumentation $builtDocumentation)
    {
        $publishedDocumentation = PublishedDocumentation::publish($builtDocumentation, __DIR__ . '/build');
        $this->documentation[(string)$builtDocumentation->getDocumentationId()] = $publishedDocumentation;
    }

    public function hasPublished(DocumentationId $anId)
    {
        return isset($this->documentation['' . $anId]);
    }

    public function getPublished(DocumentationId $anId)
    {
        return $this->documentation[(string)$anId];
    }

    public function findForProject($projectName)
    {
        return array_filter(
            $this->documentation,
            function (PublishedDocumentation $documentation) use ($projectName) {
                return strtolower($projectName) == $documentation->getDocumentationId()->getProjectName();
            }
        );
    }
}
