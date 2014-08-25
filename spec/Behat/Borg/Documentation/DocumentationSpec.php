<?php

namespace spec\Behat\Borg\Documentation;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationSpec extends ObjectBehavior
{
    function let(DocumentationId $anId, DocumentationSource $source)
    {
        $this->beConstructedWith($anId, $source);
    }

    function it_represents_documentation()
    {
        $this->shouldHaveType(Documentation::class);
    }

    function it_exposes_id(DocumentationId $anId)
    {
        $this->getId()->shouldReturn($anId);
    }

    function it_exposes_source(DocumentationSource $source)
    {
        $this->getSource()->shouldReturn($source);
    }

    function it_provides_time_it_was_created_at()
    {
        $this->getTime()->shouldHaveType(DateTimeImmutable::class);
    }

    function its_time_does_not_change_over_time()
    {
        $this->getTime()->shouldReturn($this->getTime());
    }
}
