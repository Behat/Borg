<?php

use Behat\Borg\SphinxDoc\DocumentationBuilder\SphinxDocumentationBuilder;

class SphinxDocumentationBuilderTest extends PHPUnit_Framework_TestCase
{
    private $builder;

    protected function setUp()
    {
        $this->builder = new SphinxDocumentationBuilder();
    }
}
