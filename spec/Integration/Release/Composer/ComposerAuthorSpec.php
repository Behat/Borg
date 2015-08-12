<?php

namespace spec\Behat\Borg\Integration\Release\Composer;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ComposerAuthorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['name' => 'everzet', 'email' => 'ever.zet@gmail.com']);
    }

    function it_has_a_name()
    {
        $this->name()->shouldReturn('everzet');
    }

    function it_has_an_email()
    {
        $this->email()->shouldReturn('ever.zet@gmail.com');
    }

    function its_email_is_optional()
    {
        $this->beConstructedWith(['name' => 'everzet']);

        $this->email()->shouldBe(null);
    }

    function it_can_not_be_constructed_from_empty_array()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', [[]]);
    }

    function it_can_not_be_constructed_from_array_without_name()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', [['email' => 'ever.zet@gmail.com']]);
    }
}
