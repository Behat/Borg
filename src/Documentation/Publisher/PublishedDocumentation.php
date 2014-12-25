<?php

namespace Behat\Borg\Documentation\Publisher;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;

final class PublishedDocumentation
{
    private $id;
    private $buildTime;
    private $documentationTime;
    private $path;

    public static function publish(BuiltDocumentation $builtDocumentation, $path)
    {
        $publishedDocumentation = new PublishedDocumentation();
        $publishedDocumentation->id = $builtDocumentation->getId();
        $publishedDocumentation->buildTime = $builtDocumentation->getBuildTime();
        $publishedDocumentation->documentationTime = $builtDocumentation->getDocumentationTime();
        $publishedDocumentation->path = $path;

        return $publishedDocumentation;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBuildTime()
    {
        return $this->buildTime;
    }

    public function getDocumentationTime()
    {
        return $this->documentationTime;
    }

    public function getPublishPath()
    {
        return $this->path;
    }

    private function __construct() { }
}
