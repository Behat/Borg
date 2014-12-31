<?php

namespace spec\Behat\Borg\Documentation\Page;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PageSpec extends ObjectBehavior
{
    function let(
        BuiltDocumentation $built,
        DocumentationId $documentationId,
        \DateTimeImmutable $documentationTime
    ) {
        $documentationId->getProjectName()->willReturn('behat/docs');
        $documentationId->getVersionString()->willReturn('v3.1');

        $built->getDocumentationId()->willReturn($documentationId);
        $built->getBuildTime()->willReturn(new \DateTimeImmutable());
        $built->getDocumentationTime()->willReturn($documentationTime);

        $this->beConstructedWith(
            PublishedDocumentation::publish($built->getWrappedObject(), __DIR__),
            new PageId(basename(__FILE__))
        );
    }

    function it_stores_a_project_name()
    {
        $this->getProjectName()->shouldReturn('behat/docs');
    }

    function it_stores_a_version_string()
    {
        $this->getVersionString()->shouldReturn('v3.1');
    }

    function it_stores_documentation_time(\DateTimeImmutable $documentationTime)
    {
        $this->getDocumentationTime()->shouldReturn($documentationTime);
    }

    function it_has_a_path()
    {
        $this->getPath()->shouldReturn(__FILE__);
    }

    function it_can_be_converted_to_string()
    {
        $this->__toString()->shouldReturn(__FILE__);
    }
}
