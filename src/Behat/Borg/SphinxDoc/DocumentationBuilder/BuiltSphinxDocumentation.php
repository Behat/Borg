<?php

namespace Behat\Borg\SphinxDoc\DocumentationBuilder;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;

final class BuiltSphinxDocumentation implements BuiltDocumentation
{
    private $anId;
    private $buildPath;

    public function __construct(DocumentationId $anId, $buildPath)
    {
        $this->anId = $anId;
        $this->buildPath = $buildPath;
    }

    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public function getBuildPath()
    {
        return $this->buildPath;
    }

    public function getIndexPath()
    {
        return $this->getBuildPath() . '/index.html';
    }
}
