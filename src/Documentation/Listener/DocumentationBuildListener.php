<?php

namespace Behat\Borg\Documentation\Listener;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;

interface DocumentationBuildListener
{
    public function documentationWasBuilt(BuiltDocumentation $builtDocumentation);
}
