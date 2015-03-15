<?php

namespace spec\Behat\Borg\Integration\Documentation\SphinxDoc;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuiltSphinxSpec extends ObjectBehavior
{
    function let(
        DateTimeImmutable $documentationTime,
        DateTimeImmutable $buildTime
    ) {
        $this->beConstructedWith(new DocumentationId('behat/behat', 'v1.0'), $documentationTime, $buildTime, __DIR__);
    }

    function it_is_a_built_documentation()
    {
        $this->shouldHaveType(BuiltDocumentation::class);
    }

    function it_has_a_documentation_id()
    {
        $this->documentationId()->shouldBeLike(new DocumentationId('behat/behat', 'v1.0'));
    }

    function it_has_a_path_documentation_was_built_into()
    {
        $this->buildPath()->shouldReturn(__DIR__);
    }

    function it_has_an_index_path_which_is_the_index_html_inside_the_built_path()
    {
        $this->indexPath()->shouldReturn(__DIR__ . '/index.html');
    }

    function it_has_time_at_which_it_was_built(DateTimeImmutable $buildTime)
    {
        $this->builtAt()->shouldHaveType($buildTime);
    }

    function it_has_time_at_which_original_documentation_was_created_or_updated(
        DateTimeImmutable $documentationTime
    ) {
        $this->documentedAt()->shouldReturn($documentationTime);
    }
}
