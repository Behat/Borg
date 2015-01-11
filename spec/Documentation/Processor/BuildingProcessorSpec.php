<?php

namespace spec\Behat\Borg\Documentation\Processor;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Processor\Processor;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\Documentation\RawDocumentation;
use Behat\Borg\Documentation\Repository\Repository;
use Behat\Borg\Documentation\Source;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuildingProcessorSpec extends ObjectBehavior
{
    function let(Builder $builder, Publisher $publisher, Repository $repository)
    {
        $this->beConstructedWith($builder, $publisher, $repository);
    }

    function it_is_documentation_processor()
    {
        $this->shouldHaveType(Processor::class);
    }

    function it_builds_publishes_and_saves_documentation_to_repository(
        Builder $builder,
        DocumentationId $anId,
        Source $source,
        BuiltDocumentation $builtDocumentation,
        Publisher $publisher,
        Repository $repository
    ) {
        $raw = new RawDocumentation(
            $anId->getWrappedObject(), new \DateTimeImmutable(), $source->getWrappedObject()
        );
        $published = PublishedDocumentation::publish($builtDocumentation->getWrappedObject(), '/');

        $builder->build($raw)->willReturn($builtDocumentation);
        $publisher->publish($builtDocumentation)->willReturn($published);
        $repository->save($published)->shouldBeCalled();

        $this->process($raw);
    }
}
