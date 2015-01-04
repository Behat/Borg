<?php

namespace spec\Behat\Borg\Documentation\Page;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PageSpec extends ObjectBehavior
{
    function let(
        BuiltDocumentation $built,
        DocumentationId $documentationId,
        DateTimeImmutable $documentationTime
    ) {
        $documentationId->getProjectName()->willReturn('behat/docs');
        $documentationId->getVersionString()->willReturn('v3.1');

        $built->getDocumentationId()->willReturn($documentationId);
        $built->getBuildTime()->willReturn(new DateTimeImmutable());
        $built->getDocumentationTime()->willReturn($documentationTime);

        $this->beConstructedWith(
            PublishedDocumentation::publish($built->getWrappedObject(), __DIR__),
            new PageId(basename(__FILE__))
        );
    }

    function its_project_name_is_the_project_name_of_the_published_documentation()
    {
        $this->getProjectName()->shouldReturn('behat/docs');
    }

    function its_version_string_is_the_version_string_of_the_published_documentation()
    {
        $this->getVersionString()->shouldReturn('v3.1');
    }

    function its_documentation_time_is_the_time_of_the_published_documentation(DateTimeImmutable $documentationTime)
    {
        $this->getDocumentationTime()->shouldReturn($documentationTime);
    }

    function it_has_a_full_path_to_the_page()
    {
        $this->getPath()->shouldReturn(__FILE__);
    }

    function its_string_representation_is_a_full_path_to_the_page()
    {
        $this->__toString()->shouldReturn(__FILE__);
    }
}
