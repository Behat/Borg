<?php

namespace spec\Behat\Borg\Documentation;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Source;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Repository;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\Version;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationSpec extends ObjectBehavior
{
    function let(DocumentationId $anId, Source $source)
    {
        $this->beConstructedWith($anId, new DateTimeImmutable(), $source);
    }

    function it_represents_documentation()
    {
        $this->shouldHaveType(Documentation::class);
    }

    function it_has_an_id(DocumentationId $anId)
    {
        $this->getId()->shouldReturn($anId);
    }

    function it_has_a_source(Source $source)
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
