<?php

namespace spec\Behat\Borg\Documentation\Publisher;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PublishedDocumentationSpec extends ObjectBehavior
{
    function let(
        BuiltDocumentation $builtDocumentation,
        DocumentationId $anId,
        \DateTimeImmutable $buildTime,
        \DateTimeImmutable $docTime
    ) {
        $builtDocumentation->getId()->willReturn($anId);
        $builtDocumentation->getBuildTime()->willReturn($buildTime);
        $builtDocumentation->getDocumentationTime()->willReturn($docTime);

        $this->beConstructedThrough('publish', [$builtDocumentation, __DIR__]);
    }

    function it_has_the_same_id_as_built_documentation(DocumentationId $anId)
    {
        $this->getId()->shouldReturn($anId);
    }

    function it_has_the_same_build_time_as_built_documentation(\DateTimeImmutable $buildTime)
    {
        $this->getBuildTime()->shouldReturn($buildTime);
    }

    function it_has_the_same_documentation_time_as_built_documentation(\DateTimeImmutable $docTime)
    {
        $this->getDocumentationTime()->shouldReturn($docTime);
    }

    function it_has_the_publish_path()
    {
        $this->getPublishPath()->shouldReturn(__DIR__);
    }

    function it_can_tell_if_file_at_provided_relative_path_exists()
    {
        $this->shouldHaveFile(basename(__FILE__));
        $this->shouldNotHaveFile('any file');
    }

    function it_can_provide_absolute_path_to_provided_relative_path()
    {
        $this->getAbsoluteFilePath(basename(__FILE__))->shouldReturn(__FILE__);
    }
}
