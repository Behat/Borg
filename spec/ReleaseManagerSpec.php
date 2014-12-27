<?php

namespace spec\Behat\Borg;

use Behat\Borg\Package\Listener\ReleaseListener;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReleaseManagerSpec extends ObjectBehavior
{
    function it_notifies_registered_listeners_during_release(
        ReleaseListener $listener1,
        ReleaseListener $listener2,
        Package $package
    ) {
        $aRelease = new Release($package->getWrappedObject(), Version::string('v2.5'));

        $listener1->packageWasReleased($aRelease)->shouldBeCalled();
        $listener2->packageWasReleased($aRelease)->shouldBeCalled();

        $this->registerListener($listener1);
        $this->registerListener($listener2);

        $this->release($aRelease);
    }
}
