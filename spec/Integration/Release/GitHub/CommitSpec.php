<?php

namespace spec\Behat\Borg\Integration\Release\GitHub;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommitSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough(
            'committedWithShaAtTime',
            [
                '839e5185da9434753db47959bee16642bb4f2ce4',
                new \DateTimeImmutable('2011-04-14T16:00:49Z')
            ]
        );
    }

    function it_holds_a_sha()
    {
        $this->sha()->shouldReturn('839e5185da9434753db47959bee16642bb4f2ce4');
    }

    function it_holds_a_time()
    {
        $this->committedAt()->shouldBeLike(new \DateTimeImmutable('2011-04-14T16:00:49Z'));
    }
}
