<?php

namespace spec\Behat\Borg\Fake\DocumentationBuilder;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FakeBuiltDocumentationSpec extends ObjectBehavior
{
    function let(
        DocumentationId $anId,
        DocumentationSource $source,
        DateTimeImmutable $docTime,
        DateTimeImmutable $buildTime
    ) {
        $this->beConstructedWith(
            new Documentation(
                $anId->getWrappedObject(), $source->getWrappedObject(), $docTime->getWrappedObject()
            ),
            $buildTime
        );
    }

    function it_is_a_built_documentation()
    {
        $this->shouldHaveType(BuiltDocumentation::class);
    }

    function it_has_an_id_which_is_the_same_as_documentation_id(DocumentationId $anId)
    {
        $this->getId()->shouldReturn($anId);
    }

    function its_build_path_is_tmp()
    {
        $this->getBuildPath()->shouldReturn('/tmp');
    }

    function its_index_path_is_index_html_in_tmp()
    {
        $this->getIndexPath()->shouldReturn('/tmp/index.html');
    }

    function it_stores_a_build_time_it_was_constructed_with(DateTimeImmutable $buildTime)
    {
        $this->getBuildTime()->shouldReturn($buildTime);
    }

    function it_exposes_documentation_time_from_documentation(DateTimeImmutable $docTime)
    {
        $this->getDocumentationTime()->shouldReturn($docTime);
    }
}
