<?php

namespace spec\Behat\Borg;

use Behat\Borg\Release\Listener\ReleaseListener;
use Behat\Borg\Release\Repository;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReleaseManagerSpec extends ObjectBehavior
{
    function it_notifies_registered_listeners_during_release(
        ReleaseListener $listener1,
        ReleaseListener $listener2,
        Repository $repository
    ) {
        $listener1->releaseReleased(Argument::which('repository', $repository->getWrappedObject()))->shouldBeCalled();
        $listener2->releaseReleased(Argument::which('repository', $repository->getWrappedObject()))->shouldBeCalled();

        $this->registerListener($listener1);
        $this->registerListener($listener2);

        $this->release($repository, Version::string('v2.5'));
    }
}
