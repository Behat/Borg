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

    function it_saves_extensions_to_repository_during_registration(Repository $repository, Extension $extension)
    {
        $repository->save($extension)->shouldBeCalled();

        $this->register($extension);
    }

    function it_finds_registered_extensions_using_repository(Repository $repository, Extension $extension)
    {
        $repository->find('some/extension')->willReturn($extension);

        $this->find('some/extension')->shouldReturn($extension);
    }

    function it_finds_all_registered_extensions_using_repository(Repository $repository, Extension $extension)
    {
        $repository->findAll()->willReturn([$extension]);

        $this->getAll()->shouldReturn([$extension]);
    }
}
