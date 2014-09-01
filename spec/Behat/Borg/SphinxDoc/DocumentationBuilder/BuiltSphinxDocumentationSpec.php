<?php

namespace spec\Behat\Borg\SphinxDoc\DocumentationBuilder;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuiltSphinxDocumentationSpec extends ObjectBehavior
{
    function let(
        DocumentationId $anId,
        DateTimeImmutable $documentationTime,
        DateTimeImmutable $buildTime
    ) {
        $this->beConstructedWith($anId, $documentationTime, $buildTime, __DIR__);
    }

    function it_is_a_built_documentation()
    {
        $this->shouldHaveType(BuiltDocumentation::class);
    }

    function it_has_an_id(DocumentationId $anId)
    {
        $this->getId()->shouldReturn($anId);
    }

    function it_has_a_path_documentation_was_built_into()
    {
        $this->getBuildPath()->shouldReturn(__DIR__);
    }

    function it_has_an_index_path_whic_is_the_index_html_inside_the_built_path()
    {
        $this->getIndexPath()->shouldReturn(__DIR__ . '/index.html');
    }

    function it_has_time_at_which_it_was_built(DateTimeImmutable $buildTime)
    {
        $this->getBuildTime()->shouldHaveType($buildTime);
    }

    function it_has_time_at_which_original_documentation_was_created_or_updated(
        DateTimeImmutable $documentationTime
    ) {
        $this->getDocumentationTime()->shouldReturn($documentationTime);
    }
}
