<?php

namespace spec\Behat\Borg;

use Behat\Borg\Extension\Extension;
use Behat\Borg\Extension\Repository\Repository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExtensionCatalogueSpec extends ObjectBehavior
{
    function let(Repository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_finds_extensions_using_repository(Repository $repository, Extension $extension)
    {
        $repository->find('some/extension')->willReturn($extension);

        $this->find('some/extension')->shouldReturn($extension);
    }
}
