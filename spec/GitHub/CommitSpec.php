<?php

namespace spec\Behat\Borg\GitHub;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommitSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough(
            'committedWithShaAt',
            [
                '839e5185da9434753db47959bee16642bb4f2ce4',
                new \DateTimeImmutable('2011-04-14T16:00:49Z')
            ]
        );
    }

    function it_has_sha()
    {
        $this->getSha()->shouldReturn('839e5185da9434753db47959bee16642bb4f2ce4');
    }

    function it_has_a_time()
    {
        $this->getTime()->shouldBeLike(new \DateTimeImmutable('2011-04-14T16:00:49Z'));
    }
}
