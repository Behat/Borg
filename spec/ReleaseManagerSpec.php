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
        Repository $package
    ) {
        $aRelease = new Release($package->getWrappedObject(), Version::string('v2.5'));

        $listener1->releaseReleased($aRelease)->shouldBeCalled();
        $listener2->releaseReleased($aRelease)->shouldBeCalled();

        $this->registerListener($listener1);
        $this->registerListener($listener2);

        $this->release($aRelease);
    }
}
