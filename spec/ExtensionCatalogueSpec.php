<?php

namespace spec\Behat\Borg;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExtensionCatalogueSpec extends ObjectBehavior
{
    function it_can_search_for_extensions()
    {
        $this->find('some/extension');
    }
}
