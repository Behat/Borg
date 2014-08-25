<?php

namespace Behat\Borg\DocumentationBuilder;

interface BuiltDocumentation
{
    public function getId();
    public function getBuildPath();
    public function getIndexPath();
}
