<?php

namespace spec\Behat\Borg;

use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReleaseManagerSpec extends ObjectBehavior
{
    function it_can_release_new_package_releases(Package $package)
    {
        $aRelease = new Release($package->getWrappedObject(), Version::string('v2.5'));
        $this->release($aRelease);
    }
}
