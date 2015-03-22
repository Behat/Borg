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

    function it_saves_extensions_to_repository_during_registration(Repository $repository)
    {
        $extension = new Extension('behat', 'symfony2-extension');

        $repository->add($extension)->shouldBeCalled();

        $this->register($extension);
    }

    function it_finds_registered_extensions_using_repository(Repository $repository)
    {
        $extension = new Extension('some', 'extension');

        $repository->extension('some/extension')->willReturn($extension);

        $this->extension('some/extension')->shouldReturn($extension);
    }

    function it_finds_all_registered_extensions_using_repository(Repository $repository)
    {
        $extension = new Extension('some', 'extension');

        $repository->all()->willReturn([$extension]);

        $this->all()->shouldReturn([$extension]);
    }
}
