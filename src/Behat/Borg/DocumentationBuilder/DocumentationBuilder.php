<?php

namespace Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;

interface DocumentationBuilder
{
    public function build(Documentation $documentation);
}
