<?php

namespace spec\Behat\Borg\Documentation\Repository;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CurrentableRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Behat\Borg\Documentation\Repository\CurrentableRepository');
    }
}
