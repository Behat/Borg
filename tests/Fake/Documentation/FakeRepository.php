<?php

namespace tests\Behat\Borg\Fake\Documentation;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Repository\Repository;

final class FakeRepository implements Repository
{
    private $documentation;

    public function save(PublishedDocumentation $published)
    {
        $this->documentation[(string)$published->getDocumentationId()] = $published;
    }

    public function find(DocumentationId $anId)
    {
        return $this->documentation[(string)$anId];
    }

    public function findForProject($projectName)
    {
        return array_filter(
            $this->documentation,
            function (PublishedDocumentation $documentation) use ($projectName) {
                return strtolower($projectName) == $documentation->getDocumentationId(
                )->getProjectName();
            }
        );
    }
}
