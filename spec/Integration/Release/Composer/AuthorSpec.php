<?php

namespace spec\Behat\Borg\Integration\Release\Composer;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('everzet', 'ever.zet@gmail.com');
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
        $this->beConstructedWith('everzet');

        $this->email()->shouldBe(null);
    }

    function it_can_be_constructed_from_array()
    {
        $withEmail = $this->fromArray(['name' => 'everzet', 'email' => 'ever.zet@gmail.com']);
        $withEmail->name()->shouldReturn('everzet');
        $withEmail->email()->shouldReturn('ever.zet@gmail.com');

        $justAName = $this->fromArray(['name' => 'everzet']);
        $justAName->name()->shouldReturn('everzet');
        $justAName->email()->shouldBe(null);
    }

    function it_can_not_be_constructed_from_empty_array()
    {
        $this->shouldThrow(InvalidArgumentException::class)->duringFromArray([]);
    }

    function it_can_not_be_constructed_from_array_without_name()
    {
        $this->shouldThrow(InvalidArgumentException::class)->duringFromArray(['email' => 'ever.zet@gmail.com']);
    }
}
