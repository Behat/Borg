<?php

namespace spec\Behat\Borg;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReleaseManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Behat\Borg\ReleaseManager');
    }
}
