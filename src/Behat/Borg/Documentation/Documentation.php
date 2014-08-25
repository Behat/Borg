<?php

namespace Behat\Borg\Documentation;

final class Documentation
{
    private $anId;
    private $source;

    public function __construct(DocumentationId $anId, DocumentationSource $source)
    {
        $this->anId = $anId;
        $this->source = $source;
    }

    public function getId()
    {
        return $this->anId;
    }

    public function getSource()
    {
        return $this->source;
    }
}
