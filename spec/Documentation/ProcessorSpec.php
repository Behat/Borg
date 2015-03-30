<?php

namespace spec\Behat\Borg\Documentation;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\Documentation\RawDocumentation;
use Behat\Borg\Documentation\Repository\Repository;
use Behat\Borg\Documentation\Source;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProcessorSpec extends ObjectBehavior
{
    function let(Builder $builder, Publisher $publisher, Repository $repository)
    {
        $this->beConstructedWith($builder, $publisher, $repository);
    }

    function it_processes_documentation_by_building_and_publishing_it(
        Builder $builder,
        Source $source,
        BuiltDocumentation $builtDocumentation,
        Publisher $publisher,
        Repository $repository
    ) {
        $anId = new DocumentationId('behat/behat', 'v1.0');
        $raw = new RawDocumentation(
            $anId, new \DateTimeImmutable(), $source->getWrappedObject()
        );
        $published = PublishedDocumentation::publish($builtDocumentation->getWrappedObject(), '/');

        $builder->build($raw)->willReturn($builtDocumentation);
        $publisher->publish($builtDocumentation)->willReturn($published);
        $repository->add($published)->shouldBeCalled();

        $this->process($raw);
    }
}
