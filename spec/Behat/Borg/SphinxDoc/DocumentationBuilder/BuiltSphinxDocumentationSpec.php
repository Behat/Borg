<?php

namespace spec\Behat\Borg\SphinxDoc\DocumentationBuilder;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\DocumentationBuilder\BuiltDocumentation;
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

    function it_is_built_documentation()
    {
        $this->shouldHaveType(BuiltDocumentation::class);
    }

    function it_exposes_an_id(DocumentationId $anId)
    {
        $this->getId()->shouldReturn($anId);
    }

    function it_exposes_path_documentation_was_built_into()
    {
        $this->getBuildPath()->shouldReturn(__DIR__);
    }

    function its_index_path_is_the_index_html_in_the_built_path()
    {
        $this->getIndexPath()->shouldReturn(__DIR__ . '/index.html');
    }

    function it_exposes_time_it_was_built_at(DateTimeImmutable $buildTime)
    {
        $this->getBuildTime()->shouldHaveType($buildTime);
    }

    function it_exposes_time_documentation_was_created_or_updated_at(
        DateTimeImmutable $documentationTime
    ) {
        $this->getDocumentationTime()->shouldReturn($documentationTime);
    }
}
